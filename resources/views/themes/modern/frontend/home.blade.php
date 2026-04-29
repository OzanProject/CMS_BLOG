@extends('themes.modern.frontend.layouts.app')

@section('content')
    @php $heroArticle = $bannerArticles->first(); @endphp

    <div class="max-w-[1200px] mx-auto px-8 py-12">

        {{-- Breadcrumbs --}}
        <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
            <a class="hover:text-primary transition-colors focus:outline-none focus:ring-2 focus:ring-secondary rounded px-1" href="{{ url('/') }}">Home</a>
        </nav>

        {{-- ═══════════════════════════════════════════════
             HERO SECTION — Featured/Banner Article
             ═══════════════════════════════════════════════ --}}
        @if($heroArticle)
        <section class="mb-section-gap grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 order-2 lg:order-1">
                <div class="inline-block px-3 py-1 mb-4 rounded bg-surface-container-high text-on-surface-variant font-label-caps text-label-caps uppercase">
                    {{ $heroArticle->is_featured ? 'Featured Analysis' : ($heroArticle->category->name ?? 'Latest') }}
                </div>
                <h1 class="font-h1 text-h1 text-on-surface mb-6 leading-tight">
                    <a href="{{ route('article.show', $heroArticle->slug) }}" class="hover:text-secondary transition-colors">
                        {{ $heroArticle->title }}
                    </a>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-6 max-w-content-max">
                    {{ Str::limit(strip_tags($heroArticle->content), 180) }}
                </p>
                <div class="flex items-center gap-4 font-meta text-meta text-outline">
                    <span class="flex items-center gap-2">
                        <span aria-hidden="true" class="material-symbols-outlined text-[18px]">person</span>
                        By {{ $heroArticle->user->name ?? 'Admin' }}
                    </span>
                    <span class="flex items-center gap-2">
                        <span aria-hidden="true" class="material-symbols-outlined text-[18px]">calendar_today</span>
                        {{ $heroArticle->published_at->format('M d, Y') }}
                    </span>
                    <span class="flex items-center gap-2">
                        <span aria-hidden="true" class="material-symbols-outlined text-[18px]">visibility</span>
                        {{ number_format($heroArticle->views) }} views
                    </span>
                </div>
            </div>
            <div class="lg:col-span-4 order-1 lg:order-2 h-[300px] lg:h-[400px] rounded-xl overflow-hidden shadow-sm relative bg-surface-container">
                @if($heroArticle->featured_image)
                    <img alt="{{ $heroArticle->title }}" class="w-full h-full object-cover absolute inset-0" src="{{ asset('storage/' . $heroArticle->featured_image) }}">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                        <span class="material-symbols-outlined text-[64px] text-outline">article</span>
                    </div>
                @endif
            </div>
        </section>
        @endif

        {{-- ═══════════════════════════════════════════════
             TRENDING BAR — Top Trending Articles
             ═══════════════════════════════════════════════ --}}
        @if(isset($trendingArticles) && $trendingArticles->count() >= 3)
        <section class="mb-section-gap border-t border-b border-surface-variant py-6">
            <div class="flex items-center gap-4 mb-4">
                <span aria-hidden="true" class="material-symbols-outlined text-primary">trending_up</span>
                <h3 class="font-h3 text-h3 text-on-surface">{{ 'Trending Now' }}</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($trendingArticles->take(3) as $index => $trending)
                    <a class="group block focus:outline-none focus:ring-2 focus:ring-secondary rounded p-1" href="{{ route('article.show', $trending->slug) }}">
                        <span class="text-primary font-bold text-xl mr-2">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="font-h3 text-[18px] leading-snug group-hover:text-secondary transition-colors">{{ $trending->title }}</span>
                    </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ═══════════════════════════════════════════════
             MAIN CONTENT + SIDEBAR
             ═══════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-section-gap">
            {{-- Main Content Grid --}}
            <div class="lg:col-span-8">
                <div class="flex items-center justify-between mb-8 pb-2 border-b border-surface-variant">
                    <h2 class="font-h2 text-h2 text-on-surface border-l-4 border-secondary-container pl-3">{{ 'Latest Editorials' }}</h2>
                    <a class="font-label-caps text-label-caps uppercase text-secondary hover:underline focus:outline-none focus:ring-2 focus:ring-secondary rounded px-1" href="{{ route('article.index') }}">View All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($latestArticles as $article)
                        {{-- Article Card --}}
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
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12 flex justify-center">
                    {{ $latestArticles->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- AdSense/Adsterra Slot --}}
                @php
                    $adstraActive = ($settings['adsterra_active'] ?? '0') === '1';
                    $sidebarAdHtml = $adstraActive && !empty($settings['adsterra_banner_300x250_script'])
                                        ? $settings['adsterra_banner_300x250_script']
                                        : ($settings['ad_sidebar_script'] ?? null);
                    $hasAdSense = ($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']);
                @endphp

                @if($sidebarAdHtml)
                <div class="border border-surface-variant rounded bg-surface p-4 text-center">
                    <span aria-hidden="true" class="font-label-caps text-[10px] text-outline tracking-wider uppercase mb-2 block">Advertisement</span>
                    <div aria-label="Advertisement Space" class="h-[250px] bg-surface-container-low flex items-center justify-center text-on-surface-variant font-meta overflow-hidden">
                        {!! $sidebarAdHtml !!}
                    </div>
                </div>
                @elseif($hasAdSense)
                <div class="border border-surface-variant rounded bg-surface p-4 text-center">
                    <span aria-hidden="true" class="font-label-caps text-[10px] text-outline tracking-wider uppercase mb-2 block">Advertisement</span>
                    <ins class="adsbygoogle" style="display:block;min-height:250px"
                         data-ad-client="{{ $settings['adsense_client_id'] }}"
                         data-ad-slot="auto" data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                </div>
                @endif

                {{-- Newsletter Widget --}}
                <div class="bg-primary-container text-on-primary-container rounded-xl p-8">
                    <div class="flex items-center gap-3 mb-4 text-on-primary">
                        <span aria-hidden="true" class="material-symbols-outlined text-[32px]">mark_email_unread</span>
                        <h3 class="font-h3 text-h3 leading-none">{{ 'The Briefing' }}</h3>
                    </div>
                    <p class="font-body-md text-body-md mb-6 opacity-90 text-on-primary-fixed-variant">
                        {{ 'Expert analysis delivered to your inbox every Tuesday.' }}
                    </p>
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
                        @csrf
                        <label class="sr-only" for="newsletter-email">Your email address</label>
                        <input class="w-full bg-surface text-on-surface px-4 py-3 rounded border border-transparent focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta placeholder-outline" id="newsletter-email" name="email" placeholder="{{ 'Your email address' }}" required type="email">
                        <button class="w-full bg-secondary text-on-secondary font-label-caps text-label-caps uppercase py-3 rounded hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary" type="submit">{{ 'Subscribe Now' }}</button>
                    </form>
                </div>

                {{-- Trending Sidebar --}}
                @if(isset($trendingArticles) && $trendingArticles->count() > 3)
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant">
                    <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">local_fire_department</span>
                        {{ 'Most Read' }}
                    </h4>
                    <div class="space-y-5">
                        @foreach($trendingArticles->skip(3)->take(4) as $index => $trend)
                            <a href="{{ route('article.show', $trend->slug) }}" class="group flex gap-4">
                                <span class="font-h2 text-[28px] font-bold text-outline/30 group-hover:text-secondary/50 transition-colors leading-none pt-1">
                                    {{ str_pad($index + 4, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <div>
                                    <h5 class="font-meta text-[14px] font-semibold text-on-surface group-hover:text-secondary transition-colors leading-snug">
                                        {{ Str::limit($trend->title, 60) }}
                                    </h5>
                                    <p class="text-[12px] text-outline mt-1">{{ $trend->category->name ?? '' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>

        {{-- ═══════════════════════════════════════════════
             BOTTOM GRID — Random/Explore Articles
             ═══════════════════════════════════════════════ --}}
        @if(isset($gridArticles) && $gridArticles->isNotEmpty())
        <section class="mb-section-gap">
            <div class="flex items-center justify-between mb-8 pb-2 border-b border-surface-variant">
                <h2 class="font-h2 text-h2 text-on-surface border-l-4 border-secondary-container pl-3">{{ 'Explore More' }}</h2>
                <a class="font-label-caps text-label-caps uppercase text-secondary hover:underline" href="{{ route('category.index') }}">All Categories</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($gridArticles as $gridArticle)
                    <a href="{{ route('article.show', $gridArticle->slug) }}" class="group block rounded-xl overflow-hidden bg-surface-container-lowest border border-surface-variant hover:shadow-lg transition-all duration-300">
                        <div class="h-40 overflow-hidden bg-surface-container-high">
                            @if($gridArticle->featured_image)
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $gridArticle->featured_image) }}" alt="{{ $gridArticle->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[40px] text-outline">article</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="text-[11px] font-label-caps text-secondary uppercase tracking-wider">{{ $gridArticle->category->name ?? '' }}</span>
                            <h3 class="font-h3 text-[16px] text-on-surface mt-2 leading-snug group-hover:text-secondary transition-colors line-clamp-2">{{ $gridArticle->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ═══════════════════════════════════════════════
             CATEGORIES EXPLORE
             ═══════════════════════════════════════════════ --}}
        @if(isset($categories) && $categories->isNotEmpty())
        <section class="mb-section-gap">
            <div class="flex items-center gap-4 mb-8">
                <span class="material-symbols-outlined text-secondary">category</span>
                <h3 class="font-h3 text-h3 text-on-surface">{{ 'Explore Categories' }}</h3>
            </div>
            <div class="flex flex-wrap gap-3">
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="px-5 py-2.5 rounded-full border border-surface-variant bg-surface-container-lowest text-on-surface-variant font-label-caps text-label-caps uppercase hover:bg-primary hover:text-on-primary hover:border-primary transition-all duration-200">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>
@endsection