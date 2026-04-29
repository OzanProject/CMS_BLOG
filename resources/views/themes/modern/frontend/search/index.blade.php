@extends('themes.modern.frontend.layouts.app')

@section('title', 'Search: ' . $query . ' — ' . ($settings['site_name'] ?? 'TechJournal'))

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-medium">{{ 'Search' }}</span>
    </nav>

    {{-- Search Header --}}
    <div class="mb-12">
        <h1 class="font-h1 text-h1 text-on-surface mb-4">
            {{ 'Search Results for:' }}
            <span class="text-secondary">"{{ $query }}"</span>
        </h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">
            {{ 'Showing' }}
            <span class="font-semibold text-on-surface">{{ $articles->total() }}</span>
            {{ 'articles matching your query.' }}
        </p>

        {{-- Search Form --}}
        <div class="mt-8 max-w-xl">
            <form action="{{ route('search') }}" method="GET" class="flex gap-2">
                <input name="q" value="{{ $query }}" placeholder="{{ 'Search articles...' }}"
                    class="flex-1 bg-surface-container-lowest px-5 py-3.5 rounded-lg border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline transition-all">
                <button type="submit" class="bg-secondary text-on-secondary px-6 py-3.5 rounded-lg font-label-caps text-label-caps uppercase hover:opacity-90 transition-opacity flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Search
                </button>
            </form>
        </div>
    </div>

    @if($articles->isEmpty())
        <div class="text-center py-24 bg-surface-container-lowest rounded-xl border border-surface-variant">
            <span class="material-symbols-outlined text-[64px] text-outline mb-4">search_off</span>
            <h3 class="font-h3 text-h3 text-on-surface mb-2">{{ 'No Results Found' }}</h3>
            <p class="text-on-surface-variant font-meta mb-8 max-w-md mx-auto">{{ 'Sorry, we couldn\'t find any articles matching your search. Please try with different keywords.' }}</p>
            <a href="{{ url('/') }}" class="bg-secondary text-on-secondary px-6 py-3 rounded font-label-caps text-label-caps uppercase hover:opacity-90 transition-opacity">
                {{ 'Back to Home' }}
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($articles as $article)
                        @include('themes.modern.frontend.layouts.partials.article_card')
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                                        {{ $articles->appends(['q' => $query])->links('themes.modern.frontend.layouts.partials.pagination') }}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- Trending --}}
                @if(isset($trendingArticles) && $trendingArticles->isNotEmpty())
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant sticky top-24">
                    <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">trending_up</span>
                        {{ 'Trending' }}
                    </h4>
                    <div class="space-y-5">
                        @foreach($trendingArticles->take(5) as $index => $trend)
                            <a href="{{ route('article.show', $trend->slug) }}" class="group flex gap-4">
                                <span class="font-h2 text-[24px] font-bold text-outline/30 group-hover:text-secondary/50 transition-colors leading-none pt-1">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <div>
                                    <h5 class="font-meta text-[14px] font-semibold text-on-surface group-hover:text-secondary transition-colors leading-snug">
                                        {{ Str::limit($trend->title, 55) }}
                                    </h5>
                                    <p class="text-[11px] text-outline mt-1">{{ $trend->category->name ?? '' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    @endif
</div>
@endsection
