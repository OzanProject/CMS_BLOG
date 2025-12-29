@extends('layouts.frontend')

@section('meta_title', 'All Categories - ' . ($settings['site_name'] ?? 'DeepBlog'))

@section('content')
<!-- Hero Section -->
<div class="breadcrumb-area position-relative pd-top-120 pd-bottom-60 overflow-hidden" style="background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);">
    <!-- Decorative Elements -->
    <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 300px; height: 300px; top: -100px; right: -50px; opacity: 0.1;"></div>
    <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 150px; height: 150px; bottom: 20px; left: 10%; opacity: 0.05;"></div>
    
    <div class="container position-relative z-index-1">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-inner">
                    <h1 class="title text-white font-weight-bold display-4 mb-3">All Categories</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb bg-transparent justify-content-center p-0 m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none"><i class="fa fa-home me-1"></i> Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Categories</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="category-area pd-top-80 pd-bottom-80 bg-light">
    <div class="container">
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
                <div class="single-category-item w-100 bg-white shadow-sm rounded-lg hover-lift p-4 text-center position-relative overflow-hidden d-flex flex-column h-100 border-0 transition-all">
                    <!-- Top Accent Line -->
                    <div class="position-absolute top-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                    
                    <div class="mb-4 mt-3">
                        <div class="icon-box d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-light text-primary mx-auto mb-3" style="width: 70px; height: 70px; background-color: rgba(13, 110, 253, 0.1);">
                            <i class="fa fa-folder-open fa-2x"></i>
                        </div>
                    </div>

                    <h4 class="mb-2 font-weight-bold text-dark">{{ $category->name }}</h4>
                    <p class="text-muted small mb-4 text-uppercase fw-bold ls-1">{{ $category->articles_count }} Articles</p>
                    
                    <div class="mt-auto">
                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary rounded-pill px-4 w-100 fw-bold shadow-sm custom-btn">
                            Explore
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded shadow-sm d-inline-block">
                    <i class="fa fa-folder-o fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No categories found.</h4>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .rounded-lg { border-radius: 12px; }
    .ls-1 { letter-spacing: 1px; }
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.5); }
    .custom-btn:hover { background-color: #0b5ed7; transform: scale(1.02); }
</style>
@endsection
