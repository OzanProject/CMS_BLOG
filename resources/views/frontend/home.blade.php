@extends('layouts.frontend')

@section('content')

    <!-- banner area start -->
    @include('frontend.home-sections.banner')
    <!-- banner area end -->

    <!-- post area start -->
    <div class="post-area pd-top-75 pd-bottom-50" id="trending">
        <div class="container">
            <div class="row">
                <!-- Trending News (Carousel) -->
                @include('frontend.home-sections.trending')
                
                <!-- Latest News (List) -->
                @include('frontend.home-sections.latest')
                
                <!-- What's New (Carousel) -->
                @include('frontend.home-sections.whats-new')
                
                <!-- Join With Us (Social & Ads) -->
                <div class="col-lg-3 col-md-6">
                    <div class="section-title">
                        <h6 class="title">{{ __('frontend.follow_us') }}</h6>
                    </div>
                    <div class="social-area-list mb-4">
                        <ul>
                            @if(isset($settings['social_facebook']))
                            <li><a class="facebook" href="{{ $settings['social_facebook'] }}"><i class="fa fa-facebook social-icon"></i><span>Facebook</span></a></li>
                            @endif
                            @if(isset($settings['social_twitter']))
                            <li><a class="twitter" href="{{ $settings['social_twitter'] }}"><i class="fa fa-twitter social-icon"></i><span>Twitter</span></a></li>
                            @endif
                            @if(isset($settings['social_youtube']))
                            <li><a class="youtube" href="{{ $settings['social_youtube'] }}"><i class="fa fa-youtube-play social-icon"></i><span>Youtube</span></a></li>
                            @endif
                             @if(isset($settings['social_instagram']))
                            <li><a class="instagram" href="{{ $settings['social_instagram'] }}"><i class="fa fa-instagram social-icon"></i><span>Instagram</span></a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="add-area">
                        @include('frontend.partials.ad-sidebar')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- post area end -->

    <!-- bottom grid area start -->
    @include('frontend.home-sections.bottom-grid')
    <!-- bottom grid area end -->

@endsection
