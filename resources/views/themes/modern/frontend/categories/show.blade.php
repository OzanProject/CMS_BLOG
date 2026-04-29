@extends('themes.modern.frontend.layouts.app')

@section('title', $category->name . ' — ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', $category->description ?? 'Browse the latest articles in ' . $category->name)

@section('content')
<main class="flex-grow w-full max-w-[1200px] mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    {{-- Left Column: Main Content --}}
    <div class="lg:col-span-8 flex flex-col gap-12">
        
        {{-- Breadcrumb & Header --}}
        <section class="flex flex-col gap-4">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 font-meta text-sm text-on-surface-variant">
                <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-on-surface font-semibold">{{ $category->name }}</span>
            </nav>
            <h1 class="font-h1 text-h1 text-on-surface leading-tight">{{ $category->name }}</h1>
            @if($category->description)
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                    {{ $category->description }}
                </p>
            @endif
        </section>

        @if($articles->isNotEmpty())
            {{-- Featured Article (Latest) --}}
            @php $featured = $articles->first(); @endphp
            <article class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_4px_16px_rgba(0,0,0,0.04)] border border-outline-variant hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)] transition-all duration-300 group cursor-pointer" 
                     onclick="window.location='{{ route('article.show', $featured->slug) }}'">
                <div class="relative h-64 md:h-80 w-full overflow-hidden">
                    <img alt="{{ $featured->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                         src="{{ asset('storage/' . $featured->featured_image) }}" loading="eager">
                    <div class="absolute top-4 left-4 bg-tertiary-fixed text-on-tertiary-container font-label-caps text-[11px] uppercase px-3 py-1.5 rounded-full shadow-sm">
                        Featured in {{ $category->name }}
                    </div>
                </div>
                <div class="p-8 flex flex-col gap-4">
                    <h2 class="font-h2 text-h2 text-on-surface group-hover:text-secondary transition-colors leading-tight">
                        <a href="{{ route('article.show', $featured->slug) }}">{{ $featured->title }}</a>
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant line-clamp-3">
                        {{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 200) }}
                    </p>
                    <div class="flex flex-wrap items-center gap-4 mt-2 font-meta text-xs text-on-surface-variant border-t border-surface-variant pt-4">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            <span>{{ $featured->user->name }}</span>
                        </div>
                        <div class="w-1 h-1 rounded-full bg-outline"></div>
                        <span>{{ $featured->published_at->format('M d, Y') }}</span>
                        <div class="w-1 h-1 rounded-full bg-outline"></div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">schedule</span>
                            <span>{{ max(1, round(str_word_count(strip_tags($featured->content)) / 200)) }} min read</span>
                        </div>
                    </div>
                </div>
            </article>

            {{-- In-article Ad (Category Page) --}}
            @if(($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
                <div class="w-full py-6 flex justify-center border-y border-outline-variant/30 my-4 bg-surface-container-low rounded-lg">
                    <div class="text-center w-full px-4">
                        <span class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest block mb-3">Advertisement</span>
                        <ins class="adsbygoogle" style="display:block"
                             data-ad-client="{{ $settings['adsense_client_id'] }}"
                             data-ad-slot="auto" data-ad-format="auto" data-full-width-responsive="true"></ins>
                        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                    </div>
                </div>
            @endif

            {{-- Recent Articles Grid --}}
            <section>
                <div class="flex items-center gap-3 mb-8">
                    <h3 class="font-h3 text-h3 text-on-surface border-l-4 border-secondary-container pl-3">More in {{ $category->name }}</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($articles->slice(1) as $article)
                        @include('themes.modern.frontend.layouts.partials.article_card')
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12 flex justify-center">
                    {{ $articles->links('themes.modern.frontend.layouts.partials.pagination') }}
                </div>
            </section>
        @else
            <div class="bg-surface-container-low p-12 rounded-xl text-center border border-outline-variant">
                <span class="material-symbols-outlined text-outline text-6xl mb-4">folder_off</span>
                <h3 class="font-h3 text-on-surface mb-2">No articles found</h3>
                <p class="font-meta text-on-surface-variant">We haven't published any articles in this category yet. Please check back later!</p>
            </div>
        @endif
    </div>

    {{-- Right Column: Sidebar --}}
    <aside class="lg:col-span-4 flex flex-col gap-8">
        
        {{-- Categories Sidebar --}}
        @php $allCategories = \App\Models\Category::withCount('articles')->having('articles_count', '>', 0)->orderBy('name', 'asc')->get(); @endphp
        @if($allCategories->isNotEmpty())
            <div class="bg-surface-container-lowest sticky top-24 rounded-lg border border-outline-variant shadow-sm w-full flex flex-col gap-1 p-5">
                <div class="mb-4">
                    <h3 class="font-h3 text-[18px] text-on-surface">Categories</h3>
                    <p class="font-meta text-xs text-on-surface-variant">Browse by Topic</p>
                </div>
                <nav class="flex flex-col gap-1">
                    @foreach($allCategories as $cat)
                        <a class="p-3 flex items-center justify-between gap-3 rounded transition-all duration-150 {{ $cat->id === $category->id ? 'bg-secondary-fixed text-on-secondary-fixed-variant font-bold border-l-4 border-secondary' : 'text-on-surface-variant hover:bg-surface-container' }}" 
                           href="{{ route('category.show', $cat->slug) }}">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-[18px]">folder</span>
                                <span class="font-manrope font-medium text-sm">{{ $cat->name }}</span>
                            </div>
                            <span class="font-meta text-[11px] bg-surface-container-high px-2 py-0.5 rounded-full text-on-surface">{{ $cat->articles_count }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>
        @endif

        {{-- Sidebar Ad --}}
        @if(($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
            <div class="w-full py-4 flex flex-col items-center bg-surface-container-low rounded-lg border border-outline-variant/30 px-4">
                <span class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest block mb-3">Advertisement</span>
                <ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px"
                     data-ad-client="{{ $settings['adsense_client_id'] }}"
                     data-ad-slot="auto"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
        @endif

        {{-- Trending Widget --}}
        @if(isset($trendingArticles) && $trendingArticles->isNotEmpty())
            <div class="bg-surface-container-lowest rounded-lg border border-outline-variant p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-6 border-b border-surface-variant pb-3">
                    <span class="material-symbols-outlined text-secondary">trending_up</span>
                    <h3 class="font-h3 text-[18px] text-on-surface">Trending Now</h3>
                </div>
                <ul class="flex flex-col gap-6">
                    @foreach($trendingArticles->take(5) as $index => $trend)
                        <li class="group cursor-pointer">
                            <a class="flex gap-4" href="{{ route('article.show', $trend->slug) }}">
                                <span class="font-h2 text-4xl text-outline/20 group-hover:text-secondary/30 transition-colors leading-none">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="flex flex-col gap-1">
                                    <h4 class="font-meta text-sm text-on-surface font-bold group-hover:text-secondary transition-colors line-clamp-2">
                                        {{ $trend->title }}
                                    </h4>
                                    <span class="font-label-caps text-[10px] text-secondary uppercase font-bold">{{ $trend->category->name ?? '' }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </aside>
</main>
@endsection
