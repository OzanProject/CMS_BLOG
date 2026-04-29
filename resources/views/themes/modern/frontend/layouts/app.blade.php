<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    
    <title>@yield('title', $settings['site_name'] ?? 'TechJournal')</title>
    <meta name="description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $settings['site_keywords'] ?? '')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- SEO & Social Media --}}
    <meta property="og:site_name" content="{{ $settings['site_name'] ?? 'TechJournal' }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $settings['site_name'] ?? 'TechJournal')">
    <meta property="og:description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta property="og:image" content="@yield('meta_image', !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '')">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ '@' . Str::slug($settings['site_name'] ?? 'TechJournal') }}">
    <meta name="twitter:title" content="@yield('title', $settings['site_name'] ?? 'TechJournal')">
    <meta name="twitter:description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta name="twitter:image" content="@yield('meta_image', !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '')">

    {{-- Structured Data: Organization --}}
    <script type="application/ld+json">
    {
      "{{ '@' }}context": "https://schema.org",
      "{{ '@' }}type": "Organization",
      "name": "{{ $settings['site_name'] ?? 'TechJournal' }}",
      "url": "{{ url('/') }}",
      "logo": "{{ !empty($settings['site_logo']) ? asset('storage/'.$settings['site_logo']) : '' }}",
      "sameAs": [
        "{{ $settings['social_facebook'] ?? '#' }}",
        "{{ $settings['social_twitter'] ?? '#' }}",
        "{{ $settings['social_instagram'] ?? '#' }}"
      ]
    }
    </script>

    {{-- Structured Data: WebSite & Search --}}
    <script type="application/ld+json">
    {
     "{{ '@' }}context": "https://schema.org",
     "{{ '@' }}type": "WebSite",
     "name": "{{ $settings['site_name'] ?? 'TechJournal' }}",
     "url": "{{ url('/') }}",
     "potentialAction": {
       "{{ '@' }}type": "SearchAction",
       "target": "{{ url('/search?q=') }}{search_term_string}",
       "query-input": "required name=search_term_string"
     }
    }
    </script>

    {{-- Performance: Preload Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&display=swap" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    {{-- Favicon --}}
    @if(!empty($settings['site_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings['site_favicon']) }}">
    @endif

    {{-- Google Analytics / AdSense Header --}}
    @if(!empty($settings['google_analytics_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings['google_analytics_id'] }}');
        </script>
    @endif

    @if(($settings['adsense_active'] ?? '0') === '1' && ($settings['adsense_auto_ads'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}" crossorigin="anonymous"></script>
    @endif

    {{-- TailwindCSS CDN with Enhanced Config --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#000000",
                        "secondary": "#0058be",
                        "secondary-container": "#2170e4",
                        "background": "#f7f9fb", /* Softer surface */
                        "surface": "#f7f9fb",
                        "surface-container": "#eceef0",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#1d1b20",
                        "on-surface-variant": "#49454f",
                        "outline": "#79747e",
                        "outline-variant": "#cac4d0"
                    },
                    fontFamily: {
                        "h1": ["Manrope", "sans-serif"],
                        "h2": ["Manrope", "sans-serif"],
                        "h3": ["Manrope", "sans-serif"],
                        "body-md": ["Newsreader", "serif"],
                        "body-lg": ["Newsreader", "serif"],
                        "meta": ["Manrope", "sans-serif"],
                        "label-caps": ["Manrope", "sans-serif"]
                    },
                    boxShadow: {
                        'premium': '0 10px 30px -10px rgba(0, 88, 190, 0.1)',
                        'premium-hover': '0 20px 40px -15px rgba(0, 88, 190, 0.15)',
                    },
                    fontSize: {
                        "h1": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "800" }],
                        "h2": ["32px", { "lineHeight": "1.3", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "h3": ["24px", { "lineHeight": "1.4", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["20px", { "lineHeight": "1.7", "fontWeight": "400" }],
                        "body-md": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "meta": ["14px", { "lineHeight": "1.5", "fontWeight": "500" }],
                        "label-caps": ["12px", { "lineHeight": "1.0", "letterSpacing": "0.05em", "fontWeight": "700" }]
                    }
                }
            }
        }
    </script>

    <style>
        body { background-color: #f7f9fb; color: #1d1b20; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        /* Premium Background Gradient */
        .bg-premium-mesh {
            background-color: #f7f9fb;
            background-image: 
                radial-gradient(at 0% 0%, rgba(33, 112, 228, 0.03) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(0, 88, 190, 0.03) 0px, transparent 50%);
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }



        /* Dark mode overrides */
        html.dark body { background-color: #111111; color: #e6e1e5; }
        html.dark .bg-premium-mesh {
            background-color: #111111;
            background-image: 
                radial-gradient(at 0% 0%, rgba(33, 112, 228, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(0, 88, 190, 0.1) 0px, transparent 50%);
        }

        /* Responsive Table Support */
        .article-body table {
            width: 100%;
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-collapse: collapse;
            margin: 2rem 0;
            border-radius: 12px;
            border: 1px solid rgba(128, 128, 128, 0.1);
        }
        .article-body table th,
        .article-body table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid rgba(128, 128, 128, 0.1);
            min-width: 120px;
        }
        .article-body table th {
            background: rgba(128, 128, 128, 0.05);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #1d1b20;
        }
        .article-body table tr:last-child td {
            border-bottom: none;
        }

        html.dark .article-body table { border-color: rgba(255, 255, 255, 0.1); }
        html.dark .article-body table th { background: rgba(255, 255, 255, 0.05); color: #e6e1e5; }
        html.dark .article-body table th,
        html.dark .article-body table td { border-color: rgba(255, 255, 255, 0.1); }
    </style>

    @stack('styles')
</head>

<body class="bg-premium-mesh text-on-surface font-body-md antialiased selection:bg-secondary-container selection:text-white pt-16">
    
    {{-- Skip to Content --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:bg-primary focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">
        Skip to content
    </a>

    @include('themes.modern.frontend.layouts.partials.header')

    <main id="main-content" class="min-h-screen">
        
        {{-- Manual AdSense Slot --}}
        @if(($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
        <div class="max-w-[1200px] mx-auto px-8 mt-2 mb-2 text-center overflow-hidden min-h-[90px]">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="auto"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        @endif

        @yield('content')
    </main>

    @include('themes.modern.frontend.layouts.partials.footer')

    {{-- Dark mode toggle logic --}}
    <script>
        const html = document.documentElement;
        const darkModeToggle = document.getElementById('darkModeToggle');

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
                darkModeToggle.textContent = html.classList.contains('dark') ? 'light_mode' : 'dark_mode';
            });
            // Set initial icon
            darkModeToggle.textContent = html.classList.contains('dark') ? 'light_mode' : 'dark_mode';
        }
    </script>

    @stack('scripts')
</body>

</html>