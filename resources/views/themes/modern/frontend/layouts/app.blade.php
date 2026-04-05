<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $settings = \App\Models\Configuration::whereIn('key', [
            'site_name',
            'site_description',
            'site_keywords',
            'site_logo',
            'site_favicon',
            'site_copyright',
            'footer_text',
            'adsense_active',
            'adsense_client_id',
            'adsense_auto_ads',
            'adsterra_active',
            'adsterra_pop_script',
            'adsterra_social_script'
        ])->pluck('value', 'key');
    @endphp

    @if(!empty($settings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings['site_favicon']) }}">
    @endif

    <title>@yield('title', $settings['site_name'] ?? 'NewsHub - Berita Terkini')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.tsx'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900 leading-normal tracking-normal">

    @include('themes.modern.frontend.layouts.partials.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('themes.modern.frontend.layouts.partials.footer')

    @stack('scripts')
</body>

</html>