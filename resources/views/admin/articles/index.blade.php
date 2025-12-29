@extends('layouts.admin')

@section('header', __('articles.title'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ __('menu.articles') }}</h6>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-danger d-none" id="bulkDeleteBtn" onclick="submitBulkDelete()">
                    <i class="fa fa-trash me-2"></i>{{ __('common.delete_selected') ?? 'Delete Selected' }}
                </button>
                <form action="{{ route('admin.articles.index') }}" method="GET" class="d-none d-md-flex">
                    <input class="form-control bg-dark border-0 me-2" type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('common.search') }}...">
                    <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                </form>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i>{{ __('common.add') }}
                </a>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-start" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0 text-nowrap">
                <thead>
                    <tr class="text-white">
                        <th scope="col">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </th>
                        <th scope="col">No</th>
                        <th scope="col">{{ __('articles.title_label') }}</th>
                        <th scope="col">{{ __('articles.category') }}</th>
                        <th scope="col">{{ __('articles.status') }}</th>
                        <th scope="col">{{ __('comments.author') ?? 'Author' }}</th>
                        <th scope="col">{{ __('articles.published') ?? 'Published' }}</th>
                        <th scope="col">{{ __('articles.views') ?? 'Views' }}</th>
                        <th scope="col">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $index => $article)
                    <tr>
                        <td>
                            <input class="form-check-input article-checkbox" type="checkbox" name="ids[]" value="{{ $article->id }}">
                        </td>
                        <td>{{ $articles->firstItem() + $index }}</td>
                        <td>
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-white hover-primary">
                                {{ Str::limit($article->title, 40) }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary">{{ $article->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $article->status === 'published' ? 'bg-success' : ($article->status === 'draft' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($article->status) }}
                            </span>
                        </td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                        <td>{{ $article->views }}</td>
                        <td>
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-info me-2">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(auth()->id() == $article->user_id || auth()->user()->role == 1)
                            <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('destroy-{{ $article->id }}').submit();" class="btn btn-sm btn-primary">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="destroy-{{ $article->id }}" action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No articles found. Start writing!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Hidden Bulk Delete Form -->
<form id="bulkDeleteForm" action="{{ route('admin.articles.bulk-destroy') }}" method="POST" class="d-none">
    @csrf
    <div id="bulkDeleteInputs"></div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.article-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

        function toggleBulkButton() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            if (anyChecked) {
                bulkDeleteBtn.classList.remove('d-none');
            } else {
                bulkDeleteBtn.classList.add('d-none');
            }
        }

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            toggleBulkButton();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', toggleBulkButton);
        });
    });

    function submitBulkDelete() {
        if (confirm('{{ __('common.confirm_delete_selected') ?? 'Are you sure you want to delete selected items?' }}')) {
            const form = document.getElementById('bulkDeleteForm');
            const inputsContainer = document.getElementById('bulkDeleteInputs');
            inputsContainer.innerHTML = ''; // Clear previous inputs

            const checkboxes = document.querySelectorAll('.article-checkbox:checked');
            checkboxes.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                inputsContainer.appendChild(input);
            });

            form.submit();
        }
    }
</script>
@endpush
@endsection
