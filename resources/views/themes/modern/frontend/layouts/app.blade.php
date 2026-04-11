<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $settings = \App\Models\Configuration::whereIn('key', [
            'site_name', 'site_description', 'site_keywords',
            'site_logo', 'site_favicon', 'site_copyright', 'footer_text',
            'google_analytics_id', 'google_verification_code',
            'adsense_active', 'adsense_client_id', 'adsense_auto_ads',
            // Adsterra — semua 5 format unit
            'adsterra_active',
            'adsterra_popunder_script',
            'adsterra_social_bar_script',
            'adsterra_banner_728x90_script',
            'adsterra_banner_300x250_script',
            'adsterra_native_banner_script',
            'adsterra_smartlink_url',
            // Ad placement scripts (generic / manual)
            'ad_header_script',
            'ad_sidebar_script',
            // Social links
            'social_facebook', 'social_twitter', 'social_instagram', 'social_youtube',
        ])->pluck('value', 'key');
    @endphp

    {{-- Dynamic Favicon --}}
    @if(!empty($settings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <title>@yield('title', ($settings['site_name'] ?? 'Editorial') . ' — ' . ($settings['site_description'] ?? ''))</title>
    <meta name="description" content="@yield('meta_description', $settings['site_description'] ?? '')">

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

    {{-- Adsterra Smartlink (direct URL — no script, used for links/banners) --}}
    {{-- Stored in settings['adsterra_smartlink_url'], used in templates directly --}}

    {{-- Google Fonts: Luxury Editorial Stack --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400..800;1,6..72,400..800&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.tsx'])

    <style>
        body { font-family: 'Public Sans', sans-serif; }
        .font-headline { font-family: 'Newsreader', Georgia, serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>

    @stack('styles')
</head>

<body class="bg-[#080C18] text-slate-200 antialiased">

    {{-- Google Tag Manager (noscript) --}}
    @if(!empty($settings['google_analytics_id']) && str_starts_with($settings['google_analytics_id'], 'GTM-'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['google_analytics_id'] }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    {{-- ═══════════════════════════════════════════════
         HEADER AD ZONE (728×90 Leaderboard)
         Priority: Adsterra Banner 728x90 → Generic Header Script → Hidden
         ═══════════════════════════════════════════════ --}}
    @php
        $adstraIsActive  = ($settings['adsterra_active'] ?? '0') === '1';
        $headerAdScript  = $adstraIsActive && !empty($settings['adsterra_banner_728x90_script'])
                            ? $settings['adsterra_banner_728x90_script']
                            : ($settings['ad_header_script'] ?? null);
    @endphp
    @if($headerAdScript)
        <div class="w-full flex justify-center items-center py-2.5 bg-slate-950/60 border-b border-slate-900/50">
            <div class="w-full max-w-[728px] min-h-[90px] flex justify-center items-center overflow-hidden">
                {!! $headerAdScript !!}
            </div>
        </div>
    @endif

    @include('themes.modern.frontend.layouts.partials.header')

    {{-- Adsterra Native Banner (below header, full width) --}}
    @if($adstraIsActive && !empty($settings['adsterra_native_banner_script']))
        <div class="w-full bg-slate-950/30 border-b border-slate-900/30">
            <div class="max-w-7xl mx-auto px-4">
                {!! $settings['adsterra_native_banner_script'] !!}
            </div>
        </div>
    @endif

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('themes.modern.frontend.layouts.partials.footer')

    {{-- ═══════════════════════════════════════════════
         ADSTERRA SCRIPTS (Injected before </body>)
         Order matters: Popunder → Social Bar
         ═══════════════════════════════════════════════ --}}

    {{-- Adsterra Popunder --}}
    @if($adstraIsActive && !empty($settings['adsterra_popunder_script']))
        {!! $settings['adsterra_popunder_script'] !!}
    @endif

    {{-- Adsterra Social Bar --}}
    @if($adstraIsActive && !empty($settings['adsterra_social_bar_script']))
        {!! $settings['adsterra_social_bar_script'] !!}
    @endif

    @stack('scripts')
</body>

</html>