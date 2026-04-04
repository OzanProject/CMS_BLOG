<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $settings = \App\Models\Configuration::whereIn('key', [
            'site_name', 'site_description', 'site_keywords', 'site_logo', 'site_favicon', 'site_copyright', 'footer_text',
            'google_verification_code', 'google_analytics_id', 'adsense_active', 'adsense_client_id',
            'adsense_auto_ads', 'adsterra_active', 'adsterra_pop_script', 'adsterra_social_script'
        ])->pluck('value', 'key');
    @endphp

    <!-- SEO Meta Tags -->
    <title>@yield('title', $settings['site_name'] ?? 'The Editorial Authority')</title>
    <meta name="description" content="@yield('meta_description', $settings['site_description'] ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $settings['site_keywords'] ?? '')">
    
    @if(!empty($settings['google_verification_code']))
        {!! $settings['google_verification_code'] !!}
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Google AdSense Auto Ads -->
    @if(($settings['adsense_active'] ?? '0') === '1' && ($settings['adsense_auto_ads'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}" crossorigin="anonymous"></script>
    @endif

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-surface text-on-surface font-body">

    <!-- Top Banner Ad Placeholder (Dynamic) -->
    @if(($settings['adsense_active'] ?? '0') === '1' || ($settings['adsterra_active'] ?? '0') === '1')
        <div class="w-full bg-surface-container-low py-4 flex justify-center items-center">
            <div class="w-full max-w-[728px] min-h-[90px] bg-surface-container-highest flex flex-col justify-center items-center rounded-lg overflow-hidden">
                @php $headerAd = \App\Models\Configuration::where('key', 'ad_header_script')->value('value'); @endphp
                @if($headerAd)
                    {!! $headerAd !!}
                @else
                    <span class="text-[0.6875rem] uppercase tracking-widest text-on-surface-variant font-medium mb-1">Advertisement</span>
                    <div class="text-on-surface-variant/40 italic text-sm">Header Ad Space</div>
                @endif
            </div>
        </div>
    @endif

    <!-- Top Navigation Bar -->
    <header class="w-full sticky top-0 z-50 bg-surface dark:bg-slate-950 shadow-sm backdrop-blur-md bg-opacity-80">
        <div class="flex flex-col items-center w-full max-w-7xl mx-auto px-6">
            <div class="w-full py-4 flex justify-between items-center">
                <a href="{{ url('/') }}" class="font-headline font-black text-3xl uppercase tracking-tighter text-slate-900 dark:text-white">
                    @if(isset($settings['site_logo']))
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['site_name'] }}" class="h-10 inline-block mr-2">
                    @endif
                    {{ $settings['site_name'] ?? 'The Editorial Authority' }}
                </a>
                
                <div class="flex items-center gap-6">
                    <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center bg-surface-container-highest px-4 py-2 rounded-full">
                        <span class="material-symbols-outlined text-on-surface-variant text-lg mr-2">search</span>
                        <input name="q" class="bg-transparent border-none focus:ring-0 text-sm w-48 font-body" placeholder="Search stories..." type="text" value="{{ request('q') }}"/>
                    </form>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="material-symbols-outlined text-slate-900 dark:text-slate-100">dashboard</a>
                        @endauth
                        <button class="bg-secondary text-on-secondary px-6 py-2 rounded-xl text-sm font-bold transition-transform hover:scale-95 active:duration-100">Subscribe</button>
                    </div>
                </div>
            </div>
            
            <nav class="w-full flex items-center justify-center gap-8 py-3 overflow-x-auto no-scrollbar border-t border-outline-variant/10">
                <a href="{{ url('/') }}" class="font-headline text-lg tracking-tight {{ request()->is('/') ? 'text-slate-900 dark:text-white border-b-2 border-primary' : 'text-slate-500 dark:text-slate-400' }} pb-1 whitespace-nowrap">Home</a>
                @php $categories = \App\Models\Category::all(); @endphp
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="font-headline text-lg tracking-tight {{ request()->is('category/'.$cat->slug) ? 'text-slate-900 dark:text-white border-b-2 border-primary' : 'text-slate-500 dark:text-slate-400' }} hover:text-slate-900 transition-colors duration-200 whitespace-nowrap">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Footer Section -->
    <footer class="w-full mt-20 bg-primary-container dark:bg-black text-white">
        <div class="w-full py-12 px-8 flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto">
            <div class="mb-8 md:mb-0 text-center md:text-left">
                <div class="font-headline text-xl font-bold text-white mb-2">{{ $settings['site_name'] ?? 'The Editorial Authority' }}</div>
                <p class="font-body text-xs uppercase tracking-widest text-slate-400">
                    © {{ date('Y') }} {{ $settings['site_name'] ?? 'The Editorial Authority' }}
                    @if(isset($settings['footer_text']))
                        . {{ $settings['footer_text'] }}
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <a class="font-body text-xs uppercase tracking-widest text-slate-400 hover:text-white underline decoration-secondary underline-offset-4 transition-colors" href="#">About Us</a>
                <a class="font-body text-xs uppercase tracking-widest text-slate-400 hover:text-white underline decoration-secondary underline-offset-4 transition-colors" href="#">Contact</a>
                @php $socials = ['Facebook' => 'social_facebook', 'Twitter' => 'social_twitter', 'Instagram' => 'social_instagram', 'YouTube' => 'social_youtube']; @endphp
                @foreach($socials as $name => $key)
                    @if(!empty($settings[$key]))
                        <a class="font-body text-xs uppercase tracking-widest text-slate-400 hover:text-white underline decoration-secondary underline-offset-4 transition-colors" href="{{ $settings[$key] }}">{{ $name }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </footer>

    <!-- Adsterra Scripts -->
    @if(($settings['adsterra_active'] ?? '0') === '1')
        @if(!empty($settings['adsterra_pop_script']))
            {!! $settings['adsterra_pop_script'] !!}
        @endif
        @if(!empty($settings['adsterra_social_script']))
            {!! $settings['adsterra_social_script'] !!}
        @endif
    @endif

    @stack('scripts')
</body>
</html>
