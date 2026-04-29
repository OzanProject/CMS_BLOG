@extends('themes.modern.frontend.layouts.app')

@section('title', 'All Articles' . ' — ' . ($settings['site_name'] ?? 'TechJournal'))

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-medium">{{ 'All Articles' }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="mb-12 border-l-4 border-secondary-container pl-4">
        <h1 class="font-h1 text-h1 text-on-surface mb-2">{{ 'Editorial Archives' }}</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">{{ 'Exploring the intersection of technology, culture, and business.' }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Main Articles Grid --}}
        <div class="lg:col-span-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($articles as $article)
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
                            <div class="flex items-center justify-between mb-3 relative z-20">
                                <a class="inline-block px-2 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-caps text-label-caps uppercase hover:opacity-80" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
                                <span class="font-meta text-meta text-outline">{{ $article->published_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="font-h3 text-h3 text-on-surface mb-3 group-hover:text-secondary transition-colors line-clamp-2">{{ $article->title }}</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                            <div class="flex items-center gap-2 text-[12px] text-outline mt-4 font-meta">
                                <span>By {{ $article->user->name ?? 'Admin' }}</span>
                                <span class="w-1 h-1 bg-outline rounded-full"></span>
                                <span>{{ $article->published_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 text-center py-20">
                        <span class="material-symbols-outlined text-[64px] text-outline mb-4">search_off</span>
                        <h3 class="font-h3 text-h3 text-on-surface mb-2">{{ 'No articles found' }}</h3>
                        <p class="text-on-surface-variant font-meta">Check back later for new content.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 space-y-8">
            {{-- Recent Articles --}}
            @if(isset($recentArticles) && $recentArticles->isNotEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant">
                <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">schedule</span>
                    {{ 'Recent Articles' }}
                </h4>
                <div class="space-y-5">
                    @foreach($recentArticles->take(5) as $index => $recent)
                        <a href="{{ route('article.show', $recent->slug) }}" class="group flex gap-4">
                            <span class="font-h2 text-[24px] font-bold text-outline/30 group-hover:text-secondary/50 transition-colors leading-none pt-1">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div>
                                <h5 class="font-meta text-[14px] font-semibold text-on-surface group-hover:text-secondary transition-colors leading-snug">
                                    {{ Str::limit($recent->title, 55) }}
                                </h5>
                                <p class="text-[11px] text-outline mt-1">{{ $recent->published_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Categories --}}
            <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant">
                <h4 class="font-h3 text-[18px] text-on-surface mb-5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">category</span>
                    {{ 'Categories' }}
                </h4>
                <div class="flex flex-wrap gap-2">
                    @foreach(\App\Models\Category::all() as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="px-4 py-2 rounded-full bg-surface-container-low border border-surface-variant text-on-surface-variant font-label-caps text-[11px] uppercase hover:bg-secondary hover:text-on-secondary hover:border-secondary transition-all">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Newsletter --}}
            <div class="bg-primary-container rounded-xl p-6 text-on-primary-container">
                <h4 class="font-h3 text-[18px] text-on-primary mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined">mail</span>
                    Newsletter
                </h4>
                <p class="text-[13px] text-on-primary-fixed-variant mb-4 opacity-90">{{ 'Stay updated with our latest articles.' }}</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                    @csrf
                    <input name="email" type="email" placeholder="{{ 'your@email.com' }}" required
                           class="w-full bg-surface text-on-surface px-4 py-3 rounded border border-transparent focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-sm placeholder-outline">
                    <button type="submit" class="w-full bg-secondary text-on-secondary font-label-caps text-label-caps uppercase py-3 rounded hover:opacity-90 transition-opacity">
                        Subscribe
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>
@endsection
