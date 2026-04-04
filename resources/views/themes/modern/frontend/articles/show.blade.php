@extends('themes.modern.frontend.layouts.app')

@section('title', $article->title . ' - ' . ($settings['site_name'] ?? 'The Editorial Authority'))
@section('meta_description', Str::limit(strip_tags($article->content), 160))

@section('content')
<!-- Main Content Canvas -->
<main class="max-w-screen-xl mx-auto lg:pl-64 flex flex-col md:flex-row min-h-screen">
    
    <!-- Sidebar Kiri (Desktop Only) - Kita ambil logic dari app layout tapi sesuaikan styling template baru -->
    <aside class="hidden lg:flex flex-col w-64 fixed left-0 top-0 pt-24 px-4 h-full bg-surface-container-low dark:bg-slate-900 rounded-r-lg z-40">
        <div class="mb-8">
            <h3 class="font-bold text-on-surface text-lg">Editorial Hub</h3>
            <p class="text-xs text-on-surface-variant uppercase tracking-widest">Precision Storytelling</p>
        </div>
        <nav class="flex flex-col gap-2 flex-grow">
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:bg-surface-container-highest dark:hover:bg-slate-800 rounded-lg transition-transform hover:translate-x-1">
                <span class="material-symbols-outlined">trending_up</span>
                <span class="font-medium text-sm">Trending Now</span>
            </a>
            <a href="{{ route('category.index') }}" class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:bg-surface-container-highest dark:hover:bg-slate-800 rounded-lg transition-transform hover:translate-x-1">
                <span class="material-symbols-outlined">visibility</span>
                <span class="font-medium text-sm">Most Read</span>
            </a>
            <div class="mt-4 p-4 bg-surface-container-highest rounded-lg text-center flex flex-col items-center justify-center min-h-[120px]">
                @php $sidebarLeftAd = \App\Models\Configuration::where('key', 'ad_sidebar_script')->value('value'); @endphp
                @if($sidebarLeftAd)
                    {!! $sidebarLeftAd !!}
                @else
                    <span class="material-symbols-outlined mb-2 text-outline">ad_units</span>
                    <span class="text-[10px] uppercase tracking-widest text-on-surface-variant">Ad Space</span>
                @endif
            </div>
        </nav>
        <div class="mt-auto pb-8 flex flex-col gap-4">
            <form action="{{ route('newsletter.subscribe') }}" method="POST">
                @csrf
                <button class="w-full bg-secondary text-on-secondary px-4 py-3 rounded-lg font-bold text-xs uppercase tracking-widest">Newsletter Signup</button>
            </form>
            <div class="flex gap-4 text-[10px] uppercase tracking-widest text-on-surface-variant">
                <a class="hover:text-primary" href="#">Privacy</a>
                <a class="hover:text-primary" href="#">Terms</a>
            </div>
        </div>
    </aside>

    <!-- Article Body -->
    <article class="flex-1 px-6 md:px-12 py-10 bg-surface">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 mb-8 text-[11px] font-medium uppercase tracking-widest text-on-surface-variant">
            <a class="hover:text-primary" href="{{ url('/') }}">Home</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface truncate max-w-[200px]">{{ $article->title }}</span>
        </nav>

        <!-- Headline -->
        <header class="mb-12">
            <div class="inline-block bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase mb-6">
                {{ $article->category->name }}
            </div>
            <h1 class="font-headline text-4xl md:text-6xl font-extrabold leading-[1.1] text-on-surface mb-6 tracking-tight">
                {{ $article->title }}
            </h1>
            @if($article->meta_description)
                <p class="font-headline text-xl md:text-2xl text-on-surface-variant italic leading-relaxed max-w-3xl border-l-4 border-secondary-container pl-6">
                    {{ $article->meta_description }}
                </p>
            @endif

            <div class="flex items-center justify-between mt-10 pb-8 border-b border-outline-variant/20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-surface-container-highest overflow-hidden">
                        @if($article->user->image)
                            <img src="{{ asset('storage/' . $article->user->image) }}" alt="{{ $article->user->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name) }}&color=7F9CF5&background=EBF4FF" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-sm text-on-surface uppercase tracking-tight">{{ $article->user->name }}</p>
                        <p class="text-xs text-on-surface-variant">Editorial Lead • {{ $article->published_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-lg">share</span>
                    </button>
                    <button class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-lg">bookmark</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        @if($article->image)
            <figure class="mb-12 -mx-6 md:mx-0">
                <img class="w-full aspect-[2/1] object-cover rounded-none md:rounded-xl shadow-lg" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                @if($article->image_caption)
                    <figcaption class="mt-4 px-6 md:px-0 text-xs text-on-surface-variant italic">
                        {{ $article->image_caption }}
                    </figcaption>
                @endif
            </figure>
        @endif

        <!-- Article Content -->
        <div class="max-w-2xl mx-auto md:mx-0">
            <div class="font-headline prose prose-lg max-w-none text-xl leading-relaxed text-on-surface 
                        prose-p:first-of-type:first-letter:text-6xl prose-p:first-of-type:first-letter:font-black 
                        prose-p:first-of-type:first-letter:mr-3 prose-p:first-of-type:first-letter:float-left 
                        prose-p:first-of-type:first-letter:text-primary prose-p:mb-8">
                @php
                    $content = \App\Helpers\ContentInjector::inject($article->content, $settings);
                @endphp
                {!! $content !!}
            </div>

            <!-- Tags & Share -->
            <div class="mt-16 pt-8 border-t border-outline-variant/20 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $article->meta_keywords ?? '') as $tag)
                        @if(trim($tag))
                            <span class="px-3 py-1 bg-surface-container text-on-surface-variant text-[11px] font-bold uppercase rounded">{{ trim($tag) }}</span>
                        @endif
                    @endforeach
                </div>
                <div class="flex gap-4">
                    <button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">share</span> Share Article
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        @if($relatedArticles->isNotEmpty())
            <section class="mt-20">
                <h3 class="font-bold text-lg uppercase tracking-widest mb-8 border-b-2 border-primary inline-block pb-1">Read More</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($relatedArticles as $rel)
                        <div class="group cursor-pointer" onclick="window.location='{{ route('article.show', $rel->slug) }}'">
                            @if($rel->image)
                                <img src="{{ asset('storage/' . $rel->image) }}" class="w-full aspect-video object-cover rounded-lg mb-4 group-hover:scale-105 transition-transform duration-500 shadow-md">
                            @endif
                            <p class="text-[10px] font-bold uppercase text-secondary tracking-widest mb-2">{{ $rel->category->name }}</p>
                            <h4 class="font-headline font-bold text-xl group-hover:underline">{{ $rel->title }}</h4>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </article>

    <!-- Right Sidebar (Popular & Ads) -->
    <aside class="w-full md:w-80 px-6 py-10 border-l border-outline-variant/10 bg-surface">
        <div class="sticky top-28">
            <!-- Ad Slot -->
            <div class="mb-12 bg-surface-container-highest p-6 rounded-lg text-center h-[250px] flex flex-col justify-center border border-outline-variant/20">
                @php $sidebarRightAd = \App\Models\Configuration::where('key', 'ad_header_script')->value('value'); @endphp
                @if($sidebarRightAd)
                    {!! $sidebarRightAd !!}
                @else
                    <span class="text-[10px] uppercase tracking-widest text-on-surface-variant">AdSense Display</span>
                    <div class="mt-4 w-full h-full border border-dashed border-outline-variant flex items-center justify-center italic text-xs text-on-surface-variant">
                        300x250 Banner Ad
                    </div>
                @endif
            </div>

            <!-- Popular Posts -->
            <div>
                <h3 class="font-bold text-sm uppercase tracking-widest mb-6 text-on-surface">Most Read</h3>
                <ul class="space-y-6">
                    @foreach($trendingArticles->take(5) as $index => $trend)
                        <li class="group flex gap-4 cursor-pointer" onclick="window.location='{{ route('article.show', $trend->slug) }}'">
                            <span class="font-headline text-3xl font-black text-surface-dim group-hover:text-secondary-container transition-colors">
                                {{ sprintf('%02d', $index + 1) }}
                            </span>
                            <div>
                                <h4 class="font-bold text-sm leading-tight group-hover:text-primary">{{ $trend->title }}</h4>
                                <p class="text-[10px] text-on-surface-variant mt-1">{{ $trend->category->name }} • {{ number_format($trend->views) }} views</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Newsletter Card -->
            <div class="mt-12 p-6 bg-primary-container rounded-xl text-on-primary">
                <h3 class="font-headline text-xl font-bold mb-2">Morning Briefing</h3>
                <p class="text-xs text-on-primary-container mb-4">The essential stories delivered to your inbox before the markets open.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <input name="email" class="w-full bg-white/10 border-none rounded-lg p-3 text-sm placeholder:text-white/40 mb-3 text-white focus:ring-1 focus:ring-white" placeholder="Your email address" type="email" required/>
                    <button class="w-full bg-secondary text-white py-3 rounded-lg font-bold text-xs uppercase tracking-widest shadow-lg">Sign Up</button>
                </form>
            </div>
        </div>
    </aside>
</main>
@endsection
