@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<div class="breadcrumb-area bg-black pd-top-100 pd-bottom-50">
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
