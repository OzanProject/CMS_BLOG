<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('meta_title', $settings['site_name'] ?? 'DeepBlog')</title>
    <meta name="description" content="@yield('meta_description', $settings['site_description'] ?? 'News & Magazine Website')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', $settings['site_name'] ?? 'DeepBlog')">
    <meta property="og:description" content="@yield('meta_description', $settings['site_description'] ?? 'News & Magazine Website')">
    <meta property="og:image" content="@yield('meta_image', isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('nextpage-lite/assets/img/logo.png'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('meta_title', $settings['site_name'] ?? 'DeepBlog')">
    <meta property="twitter:description" content="@yield('meta_description', $settings['site_description'] ?? 'News & Magazine Website')">
    <meta property="twitter:image" content="@yield('meta_image', isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('nextpage-lite/assets/img/logo.png'))">
    @if(isset($settings['google_verification_code']))
    <meta name="google-site-verification" content="{{ $settings['google_verification_code'] }}">
    @endif

    <!-- favicon -->
    @if(isset($settings['site_favicon']))
        <link rel="icon" href="{{ asset('storage/' . $settings['site_favicon']) }}" type="image/png">
    @else
        <link rel="icon" href="{{ asset('nextpage-lite/assets/img/favicon.png') }}" sizes="20x20" type="image/png">
    @endif

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('nextpage-lite/assets/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('nextpage-lite/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('nextpage-lite/assets/css/responsive.css') }}">

    <!-- Custom/Dynamic CSS if needed -->
    @stack('styles')
    @yield('schema_json')
    <style>
        @media (max-width: 991px) {
            .navbar-collapse {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: #080f2d; /* Dark Blue match */
                z-index: 9999;
                padding-bottom: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
        }
    </style>
    
    <!-- Google Analytics / GTM -->
    @if(isset($settings['google_analytics_id']))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings['google_analytics_id'] }}');
        </script>
    @endif
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">

    <!-- preloader area start -->
    <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>

    <!-- search popup start-->
    <div class="td-search-popup" id="td-search-popup">
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <div class="form-group">
                <input type="text" name="q" class="form-control" placeholder="{{ __('frontend.search_placeholder') }}" value="{{ request('q') }}">
            </div>
            <button type="submit" class="submit-btn"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <!-- search popup end-->
    <div class="body-overlay" id="body-overlay"></div>

    <!-- header start -->
    <div class="navbar-area">
        <!-- topbar end-->
        <div class="topbar-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-7 align-self-center">
                        <div class="topbar-menu text-md-left text-center">
                            <ul class="align-self-center">
                                @foreach(\App\Models\Page::where('status', 1)->take(4)->get() as $pageLink)
                                    <li><a href="{{ route('page.show', $pageLink->slug) }}">{{ $pageLink->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 mt-2 mt-md-0 text-md-right text-center">
                        <div class="topbar-social">
                            <div class="topbar-date d-none d-lg-inline-block mr-3">
                                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-white font-weight-bold' : 'text-white-50' }}">EN</a> | 
                                <a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'text-white font-weight-bold' : 'text-white-50' }}">ID</a>
                            </div>
                            <div class="topbar-date d-none d-lg-inline-block"><i class="fa fa-calendar"></i> {{ date('l, F j') }}</div>
                            <ul class="social-area social-area-2">
                                @if(isset($settings['social_facebook'])) <li><a class="facebook-icon" href="{{ $settings['social_facebook'] }}"><i class="fa fa-facebook"></i></a></li> @endif
                                @if(isset($settings['social_twitter'])) <li><a class="twitter-icon" href="{{ $settings['social_twitter'] }}"><i class="fa fa-twitter"></i></a></li> @endif
                                @if(isset($settings['social_youtube'])) <li><a class="youtube-icon" href="{{ $settings['social_youtube'] }}"><i class="fa fa-youtube-play"></i></a></li> @endif
                                @if(isset($settings['social_instagram'])) <li><a class="instagram-icon" href="{{ $settings['social_instagram'] }}"><i class="fa fa-instagram"></i></a></li> @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- topbar end-->

        <!-- adbar end-->
        <div class="adbar-area bg-black d-none d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-5 align-self-center">
                        <div class="logo text-md-left text-center">
                            <a class="main-logo" href="{{ url('/') }}">
                                <h2 class="text-white mb-0" style="font-weight: 800; letter-spacing: 1px;">{{ $settings['site_name'] ?? 'DeepBlog' }}</h2>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7 text-md-right text-center">
                        <div class="adbar-right">
                            @include('frontend.partials.ad-header')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- adbar end-->

        <!-- navbar start -->
        <nav class="navbar navbar-expand-lg">
            <div class="container nav-container">
                <div class="responsive-mobile-menu">
                    <div class="logo d-lg-none d-block">
                        <a class="main-logo" href="{{ url('/') }}">
                             <h4 class="mb-0 text-white" style="font-weight: 800; letter-spacing: 0.5px;">{{ $settings['site_name'] ?? 'DeepBlog' }}</h4>
                        </a>
                    </div>
                    <button class="menu toggle-btn d-block d-lg-none" data-target="#nextpage_main_menu" 
                    aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-left"></span>
                        <span class="icon-right"></span>
                    </button>
                </div>
                <div class="nav-right-part nav-right-part-mobile">
                    <a class="search header-search" href="#"><i class="fa fa-search"></i></a>
                </div>
                <div class="collapse navbar-collapse" id="nextpage_main_menu">
                    <ul class="navbar-nav menu-open">
                        <li class="current-menu-item">
                            <a href="{{ url('/') }}">{{ __('frontend.home') }}</a>
                        </li>                        
                        @php
                            $categories = \App\Models\Category::all();
                        @endphp
                        @foreach($categories->take(5) as $category)
                        <li>
                            <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                        </li>
                        @endforeach

                        @if($categories->count() > 5)
                        <li class="menu-item-has-children">
                            <a href="#">{{ __('frontend.more') ?? 'More' }}</a>
                            <ul class="sub-menu">
                                @foreach($categories->skip(5) as $category)
                                <li>
                                    <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                                </li>
                                @endforeach
                                <li class="bg-light">
                                    <a href="{{ route('category.index') }}" class="text-primary font-weight-bold" style="font-size: 13px;">view all...</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="nav-right-part nav-right-part-desktop">
                    <form action="{{ route('search') }}" method="GET" class="menu-search-inner">
                        <input type="text" name="q" placeholder="{{ __('frontend.search_placeholder') }}" value="{{ request('q') }}">
                        <button type="submit" class="submit-btn"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <!-- navbar end -->

    <div style="flex: 1;">
        @yield('content')
    </div>

    <!-- footer area start -->
    <div class="footer-area bg-black pd-top-95">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="widget">
                        <h5 class="widget-title">{{ __('frontend.about_us') }}</h5>
                        <div class="widget_about">
                            <p>{{ Str::limit($settings['site_description'] ?? 'Blog content description', 150) }}</p>
                            <ul class="social-area social-area-2 mt-4">
                                @if(isset($settings['social_facebook'])) <li><a class="facebook-icon" href="{{ $settings['social_facebook'] }}"><i class="fa fa-facebook"></i></a></li> @endif
                                @if(isset($settings['social_twitter'])) <li><a class="twitter-icon" href="{{ $settings['social_twitter'] }}"><i class="fa fa-twitter"></i></a></li> @endif
                                @if(isset($settings['social_youtube'])) <li><a class="youtube-icon" href="{{ $settings['social_youtube'] }}"><i class="fa fa-youtube-play"></i></a></li> @endif
                                @if(isset($settings['social_instagram'])) <li><a class="instagram-icon" href="{{ $settings['social_instagram'] }}"><i class="fa fa-instagram"></i></a></li> @endif
                                @if(isset($settings['social_google'])) <li><a class="google-icon" href="{{ $settings['social_google'] }}"><i class="fa fa-google-plus"></i></a></li> @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget_newsletter">
                        <h5 class="widget-title">{{ __('frontend.newsletter') ?? 'Newsletter' }}</h5>
                        @if(session('success'))
                            <div class="alert alert-success p-1 mb-2 text-center" style="font-size: 12px;">
                                {{ session('success') }}
                            </div>
                        @endif
                        <p class="text-white-50">{{ __('frontend.newsletter_desc') ?? 'Subscribe to get the latest updates.' }}</p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="{{ __('frontend.email') }}" required style="background: rgba(255,255,255,0.1); border: none; color: #fff;">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget">
                        <h5 class="widget-title">{{ __('frontend.contacts') }}</h5>
                        <ul class="contact_info_list">
                            @if(isset($settings['contact_address'])) <li><i class="fa fa-map-marker"></i> {{ $settings['contact_address'] }}</li> @endif
                            @if(isset($settings['contact_phone'])) <li><i class="fa fa-phone"></i> {{ $settings['contact_phone'] }}</li> @endif
                            @if(isset($settings['contact_email'])) <li><i class="fa fa-envelope-o"></i> {{ $settings['contact_email'] }}</li> @endif
                        </ul>
                    </div>
                </div>
                <!-- Popular News Widget removed or replaced with dynamic content if available -->
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget_recent_post">
                        <h5 class="widget-title">{{ __('frontend.popular_news') }}</h5>
                        @if(isset($footerPopularArticles))
                            @foreach($footerPopularArticles as $footerArticle)
                            <div class="media">
                                @if($footerArticle->image)
                                <div class="media-left" style="margin-right: 15px;">
                                    <a href="{{ route('article.show', $footerArticle->slug) }}">
                                        <img src="{{ asset('storage/' . $footerArticle->image) }}" alt="image" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    </a>
                                </div>
                                @endif
                                <div class="media-body">
                                    <h6 class="mb-3"><a href="{{ route('article.show', $footerArticle->slug) }}">{{ Str::limit($footerArticle->title, 40) }}</a></h6>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <ul class="widget_nav_menu">
                     @foreach(\App\Models\Page::where('status', 1)->where('slug', '!=', 'contact')->get() as $pageLink)
                        <li><a href="{{ route('page.show', $pageLink->slug) }}">{{ $pageLink->title }}</a></li>
                     @endforeach
                     <li><a href="{{ route('contact.index') }}">{{ __('frontend.contacts') }}</a></li>
                     <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                </ul>
                <p>{{ $settings['site_copyright'] ?? 'Copyright © 2024 ' . ($settings['site_name'] ?? 'DeepBlog') }}</p>
            </div>
        </div>
    </div>
    <!-- footer area end -->

    <!-- back to top area start -->
    <div class="back-to-top">
        <span class="back-top"><i class="fa fa-angle-up"></i></span>
    </div>
    <!-- back to top area end -->

    <!-- all plugins here -->
    <script src="{{ asset('nextpage-lite/assets/js/vendor.js') }}"></script>
    <!-- main js  -->
    <script src="{{ asset('nextpage-lite/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
