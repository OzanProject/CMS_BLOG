@extends('layouts.admin')

@section('header', __('menu.pages') ?? 'Pages')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ __('menu.pages') ?? 'Pages' }}</h6>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>{{ __('common.add') ?? 'Add New' }}
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-start" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Title</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Status</th>
                        <th scope="col">Last Updated</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>/p/{{ $page->slug }}</td>
                        <td>
                            <span class="badge {{ $page->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $page->status ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td>{{ $page->updated_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-info me-2"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No pages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
