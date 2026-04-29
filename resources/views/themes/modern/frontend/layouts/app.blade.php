<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ rtrim(config('app.url'), '/') }}{{ request()->getPathInfo() }}">

    @php
        $settings = \App\Models\Configuration::whereIn('key', [
            'site_name', 'site_description', 'site_keywords',
            'site_logo', 'site_favicon', 'site_copyright', 'footer_text',
            'google_analytics_id', 'google_verification_code',
            'adsense_active', 'adsense_client_id', 'adsense_auto_ads',
            'adsterra_active',
            'adsterra_popunder_script',
            'adsterra_social_bar_script',
            'adsterra_banner_728x90_script',
            'adsterra_banner_300x250_script',
            'adsterra_native_banner_script',
            'adsterra_smartlink_url',
            'ad_header_script',
            'ad_sidebar_script',
            'social_facebook', 'social_twitter', 'social_instagram', 'social_youtube',
            'homepage_youtube_url',
            'contact_address', 'contact_phone', 'contact_email',
        ])->pluck('value', 'key');
    @endphp

    {{-- Dynamic Favicon --}}
    @if(!empty($settings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <title>@yield('title', ($settings['site_name'] ?? 'TechJournal') . ' — ' . ($settings['site_description'] ?? 'Professional Tech Blog'))</title>
    <meta name="description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $settings['site_keywords'] ?? '')">
    <meta name="author" content="{{ $settings['site_name'] ?? 'Ozan Project' }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $settings['site_name'] ?? 'TechJournal')">
    <meta property="og:description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta property="og:image" content="@yield('meta_image', !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '')">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', $settings['site_name'] ?? 'TechJournal')">
    <meta property="twitter:description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta property="twitter:image" content="@yield('meta_image', !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '')">

    {{-- Google Search Console Verification --}}
    @if(!empty($settings['google_verification_code']))
        {!! $settings['google_verification_code'] !!}
    @endif

    {{-- Google Analytics / GTM --}}
    @if(!empty($settings['google_analytics_id']))
        @php $ga_id = $settings['google_analytics_id']; @endphp
        @if(str_starts_with($ga_id, 'GTM-'))
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $ga_id }}');</script>
        @else
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga_id }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ $ga_id }}');
            </script>
        @endif
    @endif

    {{-- Google AdSense Auto Ads --}}
    @if(($settings['adsense_active'] ?? '0') === '1' && ($settings['adsense_auto_ads'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}"
             crossorigin="anonymous"></script>
    @endif

    @yield('schema_json')

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    {{-- TailwindCSS CDN with Custom Config --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary": "#000000",
                        "surface": "#f7f9fb",
                        "on-secondary": "#ffffff",
                        "secondary-fixed": "#d8e2ff",
                        "on-primary-container": "#7c839b",
                        "on-primary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed-dim": "#b7c8e1",
                        "on-background": "#191c1e",
                        "surface-tint": "#565e74",
                        "primary": "#000000",
                        "on-error": "#ffffff",
                        "surface-variant": "#e0e3e5",
                        "outline": "#76777d",
                        "surface-container-highest": "#e0e3e5",
                        "secondary-container": "#2170e4",
                        "on-surface-variant": "#45464d",
                        "on-surface": "#191c1e",
                        "on-primary-fixed-variant": "#3f465c",
                        "error": "#ba1a1a",
                        "inverse-on-surface": "#eff1f3",
                        "tertiary-fixed": "#d3e4fe",
                        "primary-fixed": "#dae2fd",
                        "on-tertiary-fixed-variant": "#38485d",
                        "on-secondary-fixed-variant": "#004395",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed": "#001a42",
                        "surface-bright": "#f7f9fb",
                        "secondary": "#0058be",
                        "on-secondary-container": "#fefcff",
                        "on-primary-fixed": "#131b2e",
                        "tertiary-container": "#0b1c30",
                        "on-error-container": "#93000a",
                        "outline-variant": "#c6c6cd",
                        "surface-container": "#eceef0",
                        "on-tertiary-container": "#75859d",
                        "background": "#f7f9fb",
                        "inverse-surface": "#2d3133",
                        "primary-container": "#131b2e",
                        "secondary-fixed-dim": "#adc6ff",
                        "surface-dim": "#d8dadc",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#e6e8ea",
                        "primary-fixed-dim": "#bec6e0",
                        "inverse-primary": "#bec6e0",
                        "on-tertiary-fixed": "#0b1c30"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        "section-gap": "80px",
                        "base": "8px",
                        "gutter": "24px",
                        "content-max": "720px",
                        "container-max": "1200px"
                    },
                    fontFamily: {
                        "label-caps": ["Manrope"],
                        "body-md": ["Newsreader"],
                        "h1": ["Manrope"],
                        "meta": ["Manrope"],
                        "h3": ["Manrope"],
                        "h2": ["Manrope"],
                        "body-lg": ["Newsreader"]
                    },
                    fontSize: {
                        "label-caps": ["12px", { lineHeight: "1.0", letterSpacing: "0.05em", fontWeight: "700" }],
                        "body-md": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
                        "h1": ["48px", { lineHeight: "1.2", letterSpacing: "-0.02em", fontWeight: "800" }],
                        "meta": ["14px", { lineHeight: "1.5", fontWeight: "500" }],
                        "h3": ["24px", { lineHeight: "1.4", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "h2": ["32px", { lineHeight: "1.3", letterSpacing: "-0.01em", fontWeight: "700" }],
                        "body-lg": ["20px", { lineHeight: "1.7", fontWeight: "400" }]
                    }
                },
            },
        }
    </script>

    <style>
        body { background-color: #f7f9fb; color: #191c1e; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        html.dark body { background-color: #191c1e; color: #e0e3e5; }
        html.dark .dark\:bg-slate-900\/95 { background-color: rgba(15,23,42,0.95); }
        html.dark .dark\:bg-slate-950 { background-color: rgb(2,6,23); }

        /* Article content styles */
        .article-content p { margin-bottom: 1.5rem; line-height: 1.8; }
        .article-content h2 { font-size: 1.5rem; font-weight: 700; margin-top: 2.5rem; margin-bottom: 1rem; font-family: 'Manrope', sans-serif; }
        .article-content h3 { font-size: 1.25rem; font-weight: 600; margin-top: 2rem; margin-bottom: 0.75rem; font-family: 'Manrope', sans-serif; }
        .article-content blockquote { border-left: 3px solid #2170e4; padding: 1rem 1.5rem; font-style: italic; margin: 2rem 0; background: rgba(33,112,228,0.05); border-radius: 0 0.5rem 0.5rem 0; }
        .article-content img { border-radius: 0.75rem; margin: 2rem 0; max-width: 100%; }
        .article-content ul, .article-content ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
        .article-content ul li, .article-content ol li { margin-bottom: 0.5rem; }
        .article-content a { color: #0058be; text-decoration: underline; text-underline-offset: 3px; }
        .article-content a:hover { color: #2170e4; }
        .article-content pre { background: #131b2e; color: #bec6e0; padding: 1.25rem; border-radius: 0.5rem; overflow-x: auto; margin: 1.5rem 0; font-size: 0.875rem; }
        .article-content code { font-size: 0.9em; }
    </style>

    @stack('styles')
</head>

<body class="bg-surface text-on-surface font-body-md antialiased selection:bg-secondary-container selection:text-on-secondary-container pt-16">

    {{-- Google Tag Manager (noscript) --}}
    @if(!empty($settings['google_analytics_id']) && str_starts_with($settings['google_analytics_id'], 'GTM-'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['google_analytics_id'] }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    @include('themes.modern.frontend.layouts.partials.header')

    {{-- Adsterra Native Banner (below header, full width) --}}
    @php $adstraIsActive = ($settings['adsterra_active'] ?? '0') === '1'; @endphp
    @if($adstraIsActive && !empty($settings['adsterra_native_banner_script']))
        <div class="w-full bg-surface-container-low border-b border-surface-variant">
            <div class="max-w-[1200px] mx-auto px-8">
                {!! $settings['adsterra_native_banner_script'] !!}
            </div>
        </div>
    @endif

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('themes.modern.frontend.layouts.partials.footer')

    {{-- Adsterra Popunder --}}
    @if($adstraIsActive && !empty($settings['adsterra_popunder_script']))
        {!! $settings['adsterra_popunder_script'] !!}
    @endif

    {{-- Adsterra Social Bar --}}
    @if($adstraIsActive && !empty($settings['adsterra_social_bar_script']))
        {!! $settings['adsterra_social_bar_script'] !!}
    @endif

    {{-- Dark mode toggle script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkBtn = document.getElementById('darkModeToggle');
            if (darkBtn) {
                darkBtn.addEventListener('click', function() {
                    document.documentElement.classList.toggle('dark');
                    const isDark = document.documentElement.classList.contains('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    darkBtn.textContent = isDark ? 'light_mode' : 'dark_mode';
                });
            }
            // Restore saved theme
            const saved = localStorage.getItem('theme');
            if (saved === 'dark') {
                document.documentElement.classList.add('dark');
                const btn = document.getElementById('darkModeToggle');
                if (btn) btn.textContent = 'light_mode';
            }
        });
    </script>

    {{-- Search overlay script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBtn = document.getElementById('searchToggle');
            const searchOverlay = document.getElementById('searchOverlay');
            const closeSearch = document.getElementById('closeSearch');
            const searchInput = document.getElementById('searchOverlayInput');

            if (searchBtn && searchOverlay) {
                searchBtn.addEventListener('click', function() {
                    searchOverlay.classList.remove('hidden');
                    searchOverlay.classList.add('flex');
                    if (searchInput) searchInput.focus();
                });
                closeSearch?.addEventListener('click', function() {
                    searchOverlay.classList.add('hidden');
                    searchOverlay.classList.remove('flex');
                });
                searchOverlay.addEventListener('click', function(e) {
                    if (e.target === searchOverlay) {
                        searchOverlay.classList.add('hidden');
                        searchOverlay.classList.remove('flex');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>