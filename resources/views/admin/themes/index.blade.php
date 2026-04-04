@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Theme Management</h6>
                    <span class="badge bg-primary">{{ $themes->count() }} Themes Available</span>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    @foreach($themes as $theme)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card bg-dark text-white border-{{ $theme->is_active ? 'primary' : 'secondary' }}">
                            <div class="position-absolute top-0 end-0 p-2">
                                @if($theme->is_active)
                                    <span class="badge bg-primary">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $theme->name }}</h5>
                                <p class="card-text text-muted small mb-2">Folder: <code>resources/views/themes/{{ $theme->path }}</code></p>
                                <p class="card-text">
                                    {{ $theme->name == 'Modern Theme' ? 'Modern React-based UI with sleek animations.' : 'Legacy corporate design, stable and reliable.' }}
                                </p>
                                
                                <div class="mt-4 d-flex gap-2">
                                    @if(!$theme->is_active)
                                        <form action="{{ route('admin.themes.activate', $theme->id) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fa fa-play me-2"></i>Activate
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-primary w-100" disabled>
                                            <i class="fa fa-check me-2"></i>Current Theme
                                        </button>
                                    @endif
                                    
                                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-light">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-4 border-top pt-4">
                    <h6><i class="fa fa-info-circle me-2"></i>How to add more themes?</h6>
                    <p class="text-muted small">
                        To add a new theme, create a new folder under <code>resources/views/themes/</code> and add a corresponding entry to the <code>themes</code> table in the database.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
