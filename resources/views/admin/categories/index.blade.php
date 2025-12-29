@extends('layouts.admin')

@section('header', __('categories.title'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ __('menu.categories') }}</h6>
            <div class="d-flex gap-2">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="d-none d-md-flex">
                    <input class="form-control bg-dark border-0 me-2" type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('common.search') }}...">
                    <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                </form>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
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
                        <th scope="col">No</th>
                        <th scope="col">{{ __('common.name') ?? 'Name' }}</th>
                        <th scope="col">{{ __('categories.slug') ?? 'Slug' }}</th>
                        <th scope="col">{{ __('categories.description') ?? 'Description' }}</th>
                        <th scope="col">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td><span class="badge bg-dark">{{ $category->slug }}</span></td>
                        <td>{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-info me-2">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
