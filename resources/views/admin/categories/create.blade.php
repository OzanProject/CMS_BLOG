@extends('layouts.admin')

@section('header', 'Add New Category')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <!-- Form Section -->
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded p-4">
                    <h6 class="mb-4 text-white">New Category Form</h6>

                    <!-- Form Start -->
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label text-white">Category Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required
                                placeholder="Enter category name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label text-white">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Optional description">{{ old('description') }}</textarea>
                        </div>

                        <!-- Buttons: Submit & Cancel -->
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 py-2">Create Category</button>
                            <a href="{{ route('admin.categories.index') }}"
                                class="btn btn-outline-light px-4 py-2">Cancel</a>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
@endsection