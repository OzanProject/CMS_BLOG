@extends('layouts.frontend')

@section('meta_title', 'Page Not Found - ' . ($settings['site_name'] ?? 'DeepBlog'))

@section('content')
<div class="error-page-area position-relative d-flex align-items-center justify-content-center" style="min-height: 80vh; background: #f8f9fa;">
    <!-- Background Watermark -->
    <div class="position-absolute text-center w-100 h-100 d-flex align-items-center justify-content-center" style="z-index: 0; overflow: hidden;">
        <h1 class="font-weight-bold text-light" style="font-size: 25vw; opacity: 0.5; line-height: 1;">404</h1>
    </div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <!-- Icon -->
                <div class="mb-4">
                     <span class="d-inline-flex align-items-center justify-content-center bg-white shadow-sm rounded-circle" style="width: 120px; height: 120px;">
                        <i class="fa fa-exclamation-triangle fa-4x text-warning"></i>
                     </span>
                </div>
                
                <!-- Headings -->
                <h2 class="display-4 font-weight-bold text-dark mb-3">{{ __('frontend.page_not_found') ?? 'Page Not Found' }}</h2>
                <p class="h5 font-weight-normal text-muted mb-5 px-lg-5" style="line-height: 1.6;">
                    {{ __('frontend.page_not_found_desc') ?? 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.' }}
                </p>
                
                <!-- Actions -->
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
                    <a class="btn btn-primary rounded-pill px-5 py-3 shadow-lg hover-scale d-inline-flex align-items-center justify-content-center" href="{{ url('/') }}" style="min-width: 200px; gap: 10px;">
                        <i class="fa fa-home"></i> 
                        <span>{{ __('frontend.back_to_home') ?? 'Back to Home' }}</span>
                    </a>
                </div>

                <!-- Search Form -->
                <div class="mt-5 mx-auto" style="max-width: 500px;">
                    <form action="{{ route('search') }}" method="GET" class="position-relative">
                        <input type="text" name="q" class="form-control rounded-pill border-0 shadow py-3 px-4" placeholder="{{ __('frontend.search_placeholder') ?? 'Search...' }}" style="height: 60px;">
                        <button class="btn btn-primary position-absolute rounded-circle shadow-sm" type="submit" style="top: 5px; right: 5px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>   
                    <div class="mt-2 text-muted small">
                        Try searching for keywords like 
                        <a href="{{ route('search', ['q' => 'Technology']) }}">Technology</a>, 
                        <a href="{{ route('search', ['q' => 'Health']) }}">Health</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .hover-scale { transition: transform 0.3s ease; }
    .hover-scale:hover { transform: translateY(-3px); }
</style>
@endsection
