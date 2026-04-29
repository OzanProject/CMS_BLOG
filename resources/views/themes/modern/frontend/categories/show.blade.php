@extends('themes.modern.frontend.layouts.app')

@section('title', $category->name . ' — ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', $category->description ?? 'Articles in ' . $category->name)

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('category.index') }}">{{ __('frontend.categories') ?? 'Categories' }}</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-medium">{{ $category->name }}</span>
    </nav>

    {{-- Category Header --}}
    <div class="mb-12 border-l-4 border-secondary-container pl-4">
        <div class="inline-block px-3 py-1 mb-3 rounded bg-secondary-fixed text-on-secondary-fixed font-label-caps text-label-caps uppercase">
            {{ __('frontend.category') ?? 'Category' }}
        </div>
        <h1 class="font-h1 text-h1 text-on-surface mb-3">{{ $category->name }}</h1>
        @if($category->description)
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-content-max">{{ $category->description }}</p>
        @endif
        <p class="font-meta text-meta text-outline mt-3">{{ $articles->total() }} {{ __('frontend.articles') ?? 'articles' }}</p>
    </div>

    @if($articles->isEmpty())
        <div class="text-center py-24 bg-surface-container-lowest rounded-xl border border-surface-variant">
            <span class="material-symbols-outlined text-[64px] text-outline mb-4">folder_open</span>
            <h3 class="font-h3 text-h3 text-on-surface mb-2">{{ __('frontend.no_articles') ?? 'No articles yet' }}</h3>
            <p class="text-on-surface-variant font-meta mb-8">No articles have been published in this category yet.</p>
            <a href="{{ url('/') }}" class="bg-secondary text-on-secondary px-6 py-3 rounded font-label-caps text-label-caps uppercase hover:opacity-90 transition-opacity">
                {{ __('frontend.back_home') ?? 'Back to Home' }}
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Main Feed --}}
            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($articles as $article)
                        <article class="bg-surface-container-lowest rounded-xl overflow-hidden group transition-all duration-300 hover:shadow-[0_16px_32px_-12px_rgba(0,0,0,0.08)] relative focus-within:ring-2 focus-within:ring-secondary">
                            <a aria-label="Read article: {{ $article->title }}" class="absolute inset-0 z-10" href="{{ route('article.show', $article->slug) }}"></a>
                            <div class="h-48 bg-surface-variant overflow-hidden relative">
                                @if($article->featured_image)
                                    <img alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $article->featured_image) }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                                        <span class="material-symbols-outlined text-[48px] text-outline">article</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="font-meta text-meta text-outline">{{ $article->published_at->diffForHumans() }}</span>
                                    <span class="flex items-center gap-1 text-[12px] text-outline font-meta">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                                        {{ number_format($article->views) }}
                                    </span>
                                </div>
                                <h3 class="font-h3 text-h3 text-on-surface mb-3 group-hover:text-secondary transition-colors line-clamp-2">{{ $article->title }}</h3>
                                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $articles->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- Trending --}}
                @if(isset($trendingArticles) && $trendingArticles->isNotEmpty())
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant sticky top-24">
                    <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">trending_up</span>
                        {{ __('frontend.popular_news') ?? 'Popular' }}
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

                    {{-- Other Categories --}}
                    <div class="mt-8 pt-6 border-t border-surface-variant">
                        <h5 class="font-label-caps text-[11px] text-on-surface uppercase tracking-wider mb-4">{{ __('frontend.other_categories') ?? 'Other Categories' }}</h5>
                        <div class="flex flex-wrap gap-2">
                            @foreach(\App\Models\Category::where('id', '!=', $category->id)->take(8)->get() as $otherCat)
                                <a href="{{ route('category.show', $otherCat->slug) }}" class="px-3 py-1.5 rounded-full bg-surface-container-low border border-surface-variant text-on-surface-variant text-[11px] font-label-caps uppercase hover:bg-secondary hover:text-on-secondary hover:border-secondary transition-all">
                                    {{ $otherCat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </aside>
        </div>
    @endif
</div>
@endsection
