@extends('themes.modern.frontend.layouts.app')

@section('content')
    @php $heroArticle = $bannerArticles->first(); @endphp

    <div class="max-w-[1200px] mx-auto px-8 pb-12 mt-2 md:mt-4">

        {{-- HERO SECTION — Featured/Banner Article --}}
        @include('themes.modern.frontend.home_partials.hero')

        {{-- TRENDING BAR — Top Trending Articles --}}
        @include('themes.modern.frontend.home_partials.trending_bar')

        {{-- MAIN CONTENT + SIDEBAR --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-section-gap">
            {{-- Main Content Grid --}}
            <div class="lg:col-span-8">
                @include('themes.modern.frontend.home_partials.latest_articles')
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-8">
                @include('themes.modern.frontend.home_partials.sidebar')
            </aside>
        </div>

        {{-- BOTTOM GRID — Random/Explore Articles --}}
        @include('themes.modern.frontend.home_partials.explore_more')

        {{-- CATEGORIES EXPLORE --}}
        @include('themes.modern.frontend.home_partials.categories_pills')
        
    </div>
@endsection