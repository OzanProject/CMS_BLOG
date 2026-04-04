<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings['site_name'] ?? config('app.name', 'Laravel'))</title>
    <meta name="description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $settings['site_keywords'] ?? '')">
    <meta name="author" content="{{ $settings['site_name'] ?? 'DeepBlog' }}">

    <!-- Open Graph / SEO -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $settings['site_name'] ?? config('app.name', 'Laravel'))">
    <meta property="og:description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta property="og:image" content="{{ isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('logo.png') }}">

    <!-- Favicon -->
    @if(isset($settings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings['site_favicon']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
    
    @if(isset($settings['ad_header_script']))
        {!! $settings['ad_header_script'] !!}
    @endif

    <!-- Inline AdSense fallback -->
    @if(isset($settings['google_analytics_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings['google_analytics_id'] }}');
        </script>
    @endif
</head>
<body class="bg-background text-foreground antialiased">
    <div id="app">
        @yield('content')
    </div>

    <!-- Footer or other global sections can be added here -->
</body>
</html>
