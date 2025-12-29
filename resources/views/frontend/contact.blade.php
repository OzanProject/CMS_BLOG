@extends('layouts.frontend')

@section('meta_title', 'Contact Us - ' . ($settings['site_name'] ?? 'DeepBlog'))

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
                    <h1 class="title text-white font-weight-bold display-4 mb-3">{{ $title ?? __('frontend.contacts') }}</h1>
                    @include('frontend.partials.breadcrumbs', ['links' => [
                        ['url' => url('/'), 'label' => 'Home'],
                        ['label' => __('frontend.contacts')]
                    ]])
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-area pd-top-100 pd-bottom-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="row g-0 bg-white shadow-lg rounded-xl overflow-hidden contact-card">
                    
                    <!-- Left Side: Contact Form -->
                    <div class="col-lg-7 p-5">
                        <div class="pe-lg-3">
                            <h3 class="mb-2 font-weight-bold text-dark">{{ __('frontend.send_message') }}</h3>
                            <p class="text-muted mb-4">{{ __('frontend.message_placeholder') ?? 'We would love to hear from you. Fill out the form below.' }}</p>
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-lg border-0 shadow-sm mb-4" role="alert">
                                    <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" class="form-control bg-light border-0" id="nameInput" placeholder="{{ __('frontend.name') }}" value="{{ old('name') }}" required style="height: 55px; border-radius: 10px;">
                                            <label for="nameInput">{{ __('frontend.name') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control bg-light border-0" id="emailInput" placeholder="{{ __('frontend.email') }}" value="{{ old('email') }}" required style="height: 55px; border-radius: 10px;">
                                            <label for="emailInput">{{ __('frontend.email') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="subject" class="form-control bg-light border-0" id="subjectInput" placeholder="{{ __('frontend.subject') }}" value="{{ old('subject') }}" style="height: 55px; border-radius: 10px;">
                                            <label for="subjectInput">{{ __('frontend.subject') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-4">
                                            <textarea name="message" class="form-control bg-light border-0" id="messageInput" placeholder="{{ __('frontend.message') }}" required style="height: 150px; border-radius: 10px;">{{ old('message') }}</textarea>
                                            <label for="messageInput">{{ __('frontend.message') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary rounded-pill py-3 font-weight-bold shadow-sm transition-hover">
                                        <i class="fa fa-paper-plane me-2"></i> {{ __('frontend.send_message') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Side: Contact Info -->
                    <div class="col-lg-5 bg-primary position-relative overflow-hidden text-white p-5 d-flex flex-column justify-content-center">
                        <!-- Background Pattern -->
                        <div class="position-absolute top-0 end-0 p-3 opacity-10">
                            <i class="fa fa-envelope-open fa-10x" style="transform: rotate(-20deg);"></i>
                        </div>
                        <div class="position-absolute bottom-0 start-0 p-3 opacity-10">
                            <i class="fa fa-map-o fa-10x" style="transform: rotate(15deg);"></i>
                        </div>
                        
                        <div class="position-relative z-index-1 ps-lg-3">
                            <h3 class="mb-5 font-weight-bold">{{ __('frontend.contacts') }}</h3>
                            
                            <!-- Address -->
                            <div class="d-flex mb-4 align-items-center">
                                <div class="icon-box bg-white-glass text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0; backdrop-filter: blur(5px); background: rgba(255,255,255,0.2);">
                                    <i class="fa fa-map-marker fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-white-50 text-uppercase small ls-1 mb-1">Address</h6>
                                    <p class="mb-0 fw-bold">{{ $settings['contact_address'] ?? '123 Street, City, Country' }}</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="d-flex mb-4 align-items-center">
                                <div class="icon-box bg-white-glass text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0; backdrop-filter: blur(5px); background: rgba(255,255,255,0.2);">
                                    <i class="fa fa-phone fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-white-50 text-uppercase small ls-1 mb-1">Phone</h6>
                                    <p class="mb-0 fw-bold">{{ $settings['contact_phone'] ?? '+123 456 7890' }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="d-flex mb-5 align-items-center">
                                <div class="icon-box bg-white-glass text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0; backdrop-filter: blur(5px); background: rgba(255,255,255,0.2);">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-white-50 text-uppercase small ls-1 mb-1">Email</h6>
                                    <p class="mb-0 fw-bold">{{ $settings['contact_email'] ?? 'info@example.com' }}</p>
                                </div>
                            </div>

                            <!-- Social -->
                            <div class="mt-4 pt-4 border-top border-white-10">
                                <h6 class="text-white mb-3 text-uppercase small ls-1">Follow Us</h6>
                                <div class="d-flex gap-3">
                                    @foreach(['facebook', 'twitter', 'instagram', 'youtube'] as $social)
                                        @if(isset($settings["social_$social"]))
                                            <a href="{{ $settings["social_$social"] }}" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 45px; height: 45px; border-width: 2px;">
                                                <i class="fa fa-{{ $social == 'youtube' ? 'youtube-play' : $social }}"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-xl { border-radius: 20px; }
    .rounded-lg { border-radius: 12px; }
    .ls-1 { letter-spacing: 1px; }
    .opacity-10 { opacity: 0.1; }
    .bg-white-glass { background: rgba(255, 255, 255, 0.2) !important; }
    .border-white-10 { border-color: rgba(255, 255, 255, 0.1) !important; }
    .shadow-lg { box-shadow: 0 1rem 3rem rgba(0,0,0,.08) !important; }
    
    .transition-hover:hover { transform: translateY(-3px); box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.15); }
    .hover-scale:hover { transform: scale(1.1); background: white; color: var(--bs-primary); border-color: white; }
    
    /* Input Animations */
    .form-control:focus { box-shadow: none; background-color: #fff !important; ring: 2px solid var(--bs-primary); }
    .form-floating > label { padding-left: 1.5rem; }
    .form-control { padding-left: 1.5rem; }
    
    .contact-card { transform: translateY(0); transition: all 0.3s ease; }
</style>
@endsection
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-inner">
                    <h2 class="title text-white">{{ $title }}</h2>
                    <ul class="page-list text-white">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>{{ __('frontend.contacts') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-area pd-top-80 pd-bottom-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-0 bg-white shadow-lg rounded overflow-hidden">
                    <!-- Left Side: Contact Form -->
                    <div class="col-lg-7 p-5">
                        <h4 class="mb-4 text-dark font-weight-bold">{{ __('frontend.send_message') }}</h4>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="mb-2 text-muted">{{ __('frontend.name') }}</label>
                                        <input type="text" name="name" class="form-control rounded-pill bg-light border-0 px-4 py-3" placeholder="{{ __('frontend.name') }}" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="mb-2 text-muted">{{ __('frontend.email') }}</label>
                                        <input type="email" name="email" class="form-control rounded-pill bg-light border-0 px-4 py-3" placeholder="{{ __('frontend.email') }}" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label class="mb-2 text-muted">{{ __('frontend.subject') }}</label>
                                        <input type="text" name="subject" class="form-control rounded-pill bg-light border-0 px-4 py-3" placeholder="{{ __('frontend.subject') }}" value="{{ old('subject') }}">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label class="mb-2 text-muted">{{ __('frontend.message') }}</label>
                                        <textarea name="message" class="form-control rounded bg-light border-0 px-4 py-3" rows="5" placeholder="{{ __('frontend.message_placeholder') }}" required>{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 font-weight-bold">{{ __('frontend.send_message') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Right Side: Contact Info -->
                    <div class="col-lg-5 bg-primary text-white p-5 d-flex flex-column justify-content-center position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 p-3 opacity-10">
                            <i class="fa fa-envelope-open fa-10x"></i>
                        </div>
                        
                        <h4 class="mb-5 text-white font-weight-bold position-relative z-index-1">{{ __('frontend.contacts') }}</h4>
                        
                        <div class="d-flex mb-4 position-relative z-index-1">
                            <div class="icon-box bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1">Address</h6>
                                <p class="mb-0 text-white-50">{{ $settings['contact_address'] ?? '123 Street, City, Country' }}</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4 position-relative z-index-1">
                            <div class="icon-box bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1">Phone</h6>
                                <p class="mb-0 text-white-50">{{ $settings['contact_phone'] ?? '+123 456 7890' }}</p>
                            </div>
                        </div>

                        <div class="d-flex mb-5 position-relative z-index-1">
                            <div class="icon-box bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1">Email</h6>
                                <p class="mb-0 text-white-50">{{ $settings['contact_email'] ?? 'info@example.com' }}</p>
                            </div>
                        </div>

                        <div class="mt-auto position-relative z-index-1">
                            <h6 class="text-white mb-3">Follow Us</h6>
                            <div class="d-flex gap-2">
                                @if(isset($settings['social_facebook'])) <a href="{{ $settings['social_facebook'] }}" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa fa-facebook"></i></a> @endif
                                @if(isset($settings['social_twitter'])) <a href="{{ $settings['social_twitter'] }}" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa fa-twitter"></i></a> @endif
                                @if(isset($settings['social_instagram'])) <a href="{{ $settings['social_instagram'] }}" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa fa-instagram"></i></a> @endif
                                @if(isset($settings['social_youtube'])) <a href="{{ $settings['social_youtube'] }}" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa fa-youtube-play"></i></a> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .opacity-10 { opacity: 0.1; }
    .z-index-1 { z-index: 1; }
</style>
@endsection
