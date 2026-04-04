@extends('themes.modern.frontend.layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-12 gap-12 text-white">
    <!-- Side Navigation (Left - Editorial Hub) -->
    <aside class="hidden lg:flex flex-col lg:col-span-2 space-y-8">
        <div class="bg-surface-container-low dark:bg-slate-900 p-6 rounded-lg space-y-6">
            <div>
                <h3 class="font-body text-xs uppercase tracking-widest text-on-surface-variant font-bold">Editorial Hub</h3>
                <p class="text-[0.6875rem] text-on-surface-variant/70">Precision Storytelling</p>
            </div>
            <nav class="flex flex-col space-y-2">
                <a @if($trendingArticles->isNotEmpty()) href="{{ route('article.show', $trendingArticles->first()->slug) }}" @else href="#" @endif class="flex items-center gap-3 p-3 text-on-surface font-bold bg-white dark:bg-slate-800 rounded-lg hover:translate-x-1 transition-transform">
                    <span class="material-symbols-outlined text-lg">trending_up</span>
                    <span class="font-body text-sm font-medium">Trending Now</span>
                </a>
                <a @if($latestArticles->isNotEmpty()) href="{{ route('article.show', $latestArticles->first()->slug) }}" @else href="#" @endif class="flex items-center gap-3 p-3 text-on-surface-variant hover:bg-surface-container-highest dark:hover:bg-slate-800 rounded-lg hover:translate-x-1 transition-transform">
                    <span class="material-symbols-outlined text-lg">bolt</span>
                    <span class="font-body text-sm font-medium">Latest Stories</span>
                </a>
                <a href="{{ route('article.index') }}" class="flex items-center gap-3 p-3 text-on-surface-variant hover:bg-surface-container-highest dark:hover:bg-slate-800 rounded-lg hover:translate-x-1 transition-transform">
                    <span class="material-symbols-outlined text-lg">star</span>
                    <span class="font-body text-sm font-medium">All Archives</span>
                </a>
                <a href="{{ route('category.index') }}" class="flex items-center gap-3 p-3 text-on-surface-variant hover:bg-surface-container-highest dark:hover:bg-slate-800 rounded-lg hover:translate-x-1 transition-transform">
                    <span class="material-symbols-outlined text-lg">visibility</span>
                    <span class="font-body text-sm font-medium">By Categories</span>
                </a>
            </nav>
            <div class="pt-4 border-t border-outline-variant/20">
                <form action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <button class="w-full bg-primary text-on-primary py-3 rounded-xl text-xs font-bold uppercase tracking-wider">Newsletter Signup</button>
                </form>
            </div>
        </div>

        <!-- Sidebar Ad Space (Dynamic) -->
        <div class="bg-surface-container-highest h-64 rounded-lg flex flex-col justify-center items-center p-4 overflow-hidden border border-outline-variant/10">
            @php $sidebarAd = \App\Models\Configuration::where('key', 'ad_sidebar_script')->value('value'); @endphp
            @if($sidebarAd)
                {!! $sidebarAd !!}
            @else
                <span class="text-[0.6875rem] uppercase tracking-widest text-on-surface-variant font-medium mb-1">Ad Space</span>
                <div class="text-on-surface-variant/40 italic text-xs text-center">Vertical Placement</div>
            @endif
        </div>
    </aside>

    <!-- Main Feed (Center) -->
    <div class="lg:col-span-7 space-y-16">
        <!-- Hero Article Section -->
        @if($bannerArticles->isNotEmpty())
            @php $hero = $bannerArticles->first(); @endphp
            <article class="group cursor-pointer" onclick="window.location='{{ route('article.show', $hero->slug) }}'">
                <div class="relative overflow-hidden rounded-xl mb-6 shadow-2xl">
                    @if($hero->image)
                        <img src="{{ asset('storage/' . $hero->image) }}" alt="{{ $hero->title }}" class="w-full h-[500px] object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-[500px] bg-slate-800 flex items-center justify-center">
                            <span class="text-slate-600 font-headline text-4xl italic">Editorial Selection</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-8">
                        <span class="inline-block bg-secondary text-white px-3 py-1 rounded text-[0.6875rem] font-bold tracking-widest uppercase mb-4">{{ $hero->category->name }}</span>
                        <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-headline font-bold leading-tight mb-4 group-hover:underline decoration-secondary underline-offset-8">
                            {{ $hero->title }}
                        </h1>
                        <p class="text-white/80 text-lg font-body max-w-2xl line-clamp-2">
                            {{ Str::limit(strip_tags($hero->content), 150) }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-on-surface-variant text-[0.6875rem] font-bold uppercase tracking-widest px-2">
                    <span>By {{ $hero->user->name }}</span>
                    <span class="w-1 h-1 bg-outline-variant rounded-full"></span>
                    <span>{{ $hero->published_at->format('M d, Y') }}</span>
                </div>
            </article>
        @endif

        <!-- Latest News Bento Grid -->
        <section>
            <div class="flex items-end justify-between mb-8">
                <h2 class="text-3xl font-headline font-bold text-on-surface border-l-4 border-secondary pl-4">Latest Insights</h2>
                <a class="text-sm font-label font-bold text-secondary hover:underline" href="{{ route('article.index') }}">View Archives</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($latestArticles->skip(1)->take(4) as $article)
                    <div class="flex flex-col space-y-4 group cursor-pointer" onclick="window.location='{{ route('article.show', $article->slug) }}'">
                        @if($article->image)
                            <div class="overflow-hidden rounded-lg">
                                <img class="w-full aspect-video object-cover transition-transform group-hover:scale-105 duration-500" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                            </div>
                        @endif
                        <span class="text-[0.6875rem] font-bold tracking-widest uppercase text-secondary">{{ $article->category->name }}</span>
                        <h3 class="text-2xl font-headline font-bold group-hover:text-secondary transition-colors text-on-surface">{{ $article->title }}</h3>
                        <p class="text-on-surface-variant text-sm line-clamp-2">
                            {{ Str::limit(strip_tags($article->content), 100) }}
                        </p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- In-Feed Ad Placeholder -->
        @php $inFeedAd = \App\Models\Configuration::where('key', 'ad_in_article_script')->value('value'); @endphp
        @if($inFeedAd)
            <div class="bg-surface-container-low p-8 rounded-xl flex items-center justify-center overflow-hidden border border-outline-variant/10 shadow-sm">
                {!! $inFeedAd !!}
            </div>
        @else
            <div class="bg-surface-container-low p-8 rounded-xl flex items-center justify-between border border-outline-variant/10 shadow-sm">
                <div class="max-w-md">
                    <span class="text-[0.6875rem] font-bold tracking-widest uppercase text-on-surface-variant mb-2 block">Premium Insights</span>
                    <h4 class="text-xl font-headline font-bold mb-2 text-on-surface">Experience deep storytelling at your fingertips.</h4>
                    <p class="text-sm text-on-surface-variant">Stay updated with our curated editorial selection sent daily.</p>
                </div>
                <button class="bg-primary text-on-primary px-6 py-3 rounded-xl text-sm font-bold hover:bg-secondary transition-colors">Join Newsletter</button>
            </div>
        @endif
        
        <!-- Bottom Banner (Alternative Data Feed or Additional Feature) -->
        <section class="bg-primary-container p-8 rounded-xl text-white shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-6">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">star</span>
                    <h2 class="text-2xl font-headline font-bold uppercase tracking-tight">Editors Pick</h2>
                </div>
                    @foreach($gridArticles->take(3) as $article)
                        <a href="{{ route('article.show', $article->slug) }}" class="group block">
                            <h3 class="text-lg font-headline font-bold group-hover:text-secondary mb-2 line-clamp-2">{{ $article->title }}</h3>
                            <p class="text-sm text-white/60 line-clamp-1 italic">Read Analysis &rarr;</p>
                        </a>
                    @endforeach
            </div>
        </section>
    </div>

    <!-- Trending Sidebar (Right) -->
    <aside class="lg:col-span-3 space-y-12 text-on-surface">
        <section>
            <h3 class="font-label font-bold text-xs uppercase tracking-[0.2em] mb-6 border-b-2 border-secondary inline-block pb-1">Trending Stories</h3>
                @foreach($trendingArticles->take(5) as $index => $article)
                    <div class="flex gap-4 group cursor-pointer" onclick="window.location='{{ route('article.show', $article->slug) }}'">
                        <span class="text-3xl font-headline font-black text-outline-variant group-hover:text-secondary transition-colors italic">{{ sprintf('%02d', $index + 1) }}</span>
                        <div>
                            <h4 class="text-sm font-bold font-body leading-tight group-hover:underline text-on-surface">{{ $article->title }}</h4>
                            <span class="text-[10px] text-on-surface-variant font-bold mt-2 inline-block">{{ number_format($article->views) }} Analytical Engagements</span>
                        </div>
                    </div>
                @endforeach
        </section>

        <!-- Sidebar Newsletter Slot -->
        <div class="bg-surface-container-highest rounded-lg flex flex-col justify-center items-center p-8 border border-outline-variant/10 shadow-sm text-center">
            <span class="text-[0.6875rem] uppercase tracking-widest text-on-surface-variant font-medium mb-3">Newsletter</span>
            <p class="text-xs font-body mb-4 text-on-surface-variant">Get the weekend edition of our publication directly to your inbox.</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="w-full">
                @csrf
                <input name="email" class="w-full bg-white border-2 border-surface-container-highest rounded-lg text-xs py-2 px-4 mb-3 focus:ring-1 focus:ring-secondary focus:border-secondary" placeholder="email@address.com" type="email" required/>
                <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-secondary transition-colors">Sign Up Now</button>
            </form>
        </div>

        <section>
            <h3 class="font-label font-bold text-xs uppercase tracking-[0.2em] mb-6">Cultural Insights</h3>
            <div class="space-y-6">
                @if($gridArticles->isNotEmpty())
                    @php $cultural = $gridArticles->last(); @endphp
                    <div class="group cursor-pointer" onclick="window.location='{{ route('article.show', $cultural->slug) }}'">
                        <div class="relative overflow-hidden rounded-lg mb-3 shadow-md">
                            @if($cultural->image)
                                <img class="w-full aspect-square object-cover transition-transform group-hover:scale-105 duration-500" src="{{ asset('storage/' . $cultural->image) }}" alt="{{ $cultural->title }}">
                            @else
                                <div class="w-full aspect-square bg-slate-200 flex items-center justify-center text-slate-400 italic">No Media</div>
                            @endif
                        </div>
                        <h4 class="text-sm font-headline font-bold text-on-surface line-clamp-2">{{ $cultural->title }}</h4>
                    </div>
                @endif
            </div>
        </section>
    </aside>
</main>
@endsection
