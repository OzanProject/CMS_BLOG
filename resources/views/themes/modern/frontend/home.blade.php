@extends('themes.modern.frontend.layouts.app')

@section('content')
    <!-- Master React Component: ModernPage -->
    <div data-react-component="ModernPage" data-props="{{ json_encode([
        'settings' => $settings,
        'categories' => $categories,
        'bannerArticles' => $bannerArticles,
        'trendingArticles' => $trendingArticles,
        'latestArticles' => $latestArticles,
    ]) }}">
        <!-- Sophisticated Loading State -->
        <div class="min-h-screen bg-[#050505] flex flex-col items-center justify-center space-y-8">
            <div class="relative">
                <div class="h-24 w-24 rounded-full border-t-2 border-b-2 border-indigo-500 animate-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="h-16 w-16 rounded-full border-r-2 border-l-2 border-indigo-400/50 animate-spin-reverse"></div>
                </div>
            </div>
            <div class="flex flex-col items-center space-y-4">
                <div class="text-indigo-400 font-medium tracking-widest text-sm uppercase animate-pulse">
                    Memuat Pengalaman Modern
                </div>
                <div class="h-1 w-48 bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 w-1/3 animate-progress"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
