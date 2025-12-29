@extends('layouts.frontend')

@section('meta_title', 'Contact Us - ' . ($settings['site_name'] ?? 'DeepBlog'))

@section('content')
<!-- Hero Section -->
<div class="breadcrumb-area position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);">
    <!-- Decorative Elements -->
    <div class="position-absolute rounded-circle bg-white" style="width: 300px; height: 300px; top: -100px; right: -50px; opacity: 0.1;"></div>
    <div class="position-absolute rounded-circle bg-white" style="width: 150px; height: 150px; bottom: 20px; left: 10%; opacity: 0.05;"></div>
    
    <div class="container position-relative" style="z-index: 1;">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-inner pt-5 pb-5">
                    <h1 class="title text-white font-weight-bold display-4 mb-3">{{ $title ?? __('frontend.contacts') }}</h1>
                    @include('frontend.partials.breadcrumbs', ['links' => [
                        'Home' => url('/'),
                        __('frontend.contacts') => '#'
                    ]])
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-area py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="row no-gutters bg-white shadow-lg rounded overflow-hidden contact-card">
                    
                    <!-- Left Side: Contact Form -->
                    <div class="col-lg-7 p-5">
                        <div class="pr-lg-3">
                            <h3 class="mb-2 font-weight-bold text-dark">{{ __('frontend.send_message') }}</h3>
                            <p class="text-muted mb-4">{{ __('frontend.message_placeholder') ?? 'We would love to hear from you. Fill out the form below.' }}</p>
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded border-0 shadow-sm mb-4" role="alert">
                                    <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="nameInput" class="text-muted small text-uppercase font-weight-bold">{{ __('frontend.name') }}</label>
                                            <input type="text" name="name" class="form-control bg-light border-0 py-4" id="nameInput" placeholder="{{ __('frontend.name') }}" value="{{ old('name') }}" required style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="emailInput" class="text-muted small text-uppercase font-weight-bold">{{ __('frontend.email') }}</label>
                                            <input type="email" name="email" class="form-control bg-light border-0 py-4" id="emailInput" placeholder="{{ __('frontend.email') }}" value="{{ old('email') }}" required style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="subjectInput" class="text-muted small text-uppercase font-weight-bold">{{ __('frontend.subject') }}</label>
                                            <input type="text" name="subject" class="form-control bg-light border-0 py-4" id="subjectInput" placeholder="{{ __('frontend.subject') }}" value="{{ old('subject') }}" style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label for="messageInput" class="text-muted small text-uppercase font-weight-bold">{{ __('frontend.message') }}</label>
                                            <textarea name="message" class="form-control bg-light border-0" id="messageInput" rows="5" placeholder="{{ __('frontend.message') }}" required style="border-radius: 10px;">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary btn-rounded py-3 px-5 font-weight-bold shadow-sm transition-hover">
                                        <i class="fa fa-paper-plane mr-2"></i> {{ __('frontend.send_message') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Side: Contact Info -->
                    <div class="col-lg-5 bg-primary position-relative overflow-hidden text-white p-5 d-flex flex-column justify-content-center">
                        <!-- Background Pattern -->
                        <div class="position-absolute p-3 opacity-10" style="top: 0; right: 0;">
                            <i class="fa fa-envelope-open fa-5x" style="transform: rotate(-20deg);"></i>
                        </div>
                        <div class="position-absolute p-3 opacity-10" style="bottom: 0; left: 0;">
                            <i class="fa fa-map-o fa-5x" style="transform: rotate(15deg);"></i>
                        </div>
                        
                        <div class="position-relative pl-lg-3" style="z-index: 1;">
                            <h3 class="mb-5 font-weight-bold">{{ __('frontend.contacts') }}</h3>
                            
                            <!-- Address -->
                            <div class="d-flex mb-4 align-items-center">
                                <div class="icon-box bg-white-glass text-white rounded-circle d-flex align-items-center justify-content-center mr-4 shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0;">
                                    <i class="fa fa-map-marker fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-white-50 text-uppercase small ls-1 mb-1">Address</h6>
                                    <p class="mb-0 font-weight-bold">{{ $settings['contact_address'] ?? '123 Street, City, Country' }}</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="d-flex mb-4 align-items-center">
                                <div class="icon-box bg-white-glass text-white rounded-circle d-flex align-items-center justify-content-center mr-4 shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0;">
                                    <i class="fa fa-phone fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-white-50 text-uppercase small ls-1 mb-1">Phone</h6>
                                    <p class="mb-0 font-weight-bold">{{ $settings['contact_phone'] ?? '+123 456 7890' }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="d-flex mb-5 align-items-center">
                                <div class="icon-box bg-white-glass text-white rounded-circle d-flex align-items-center justify-content-center mr-4 shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0;">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-white-50 text-uppercase small ls-1 mb-1">Email</h6>
                                    <p class="mb-0 font-weight-bold">{{ $settings['contact_email'] ?? 'info@example.com' }}</p>
                                </div>
                            </div>

                            <!-- Social -->
                            <div class="mt-4 pt-4 border-top border-white-10">
                                <h6 class="text-white mb-3 text-uppercase small ls-1">Follow Us</h6>
                                <div class="d-flex">
                                    @foreach(['facebook', 'twitter', 'instagram', 'youtube'] as $social)
                                        @if(isset($settings["social_$social"]))
                                            <a href="{{ $settings["social_$social"] }}" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center hover-scale mr-2" style="width: 45px; height: 45px; border-width: 2px;">
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
    /* Custom Utils for BS4 Compatibility */
    .bg-white-glass { background: rgba(255, 255, 255, 0.2) !important; backdrop-filter: blur(5px); }
    .border-white-10 { border-color: rgba(255, 255, 255, 0.1) !important; }
    .opacity-10 { opacity: 0.1; }
    .ls-1 { letter-spacing: 1px; }
    
    /* Button Styles */
    .btn-rounded { border-radius: 50px !important; }
    
    /* Animations & Hover Effects */
    .transition-hover:hover { transform: translateY(-3px); box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.15); }
    .hover-scale:hover { transform: scale(1.1); background: white; color: var(--blue); border-color: white; }
    
    /* Form Inputs */
    .form-control:focus { box-shadow: none; background-color: #fff !important; border: 2px solid var(--blue) !important; }
    
    .contact-card { transition: all 0.3s ease; }
</style>
@endsection
