@if(isset($trendingArticles) && $trendingArticles->count() >= 3)
<section class="mb-section-gap border-t border-b border-surface-variant py-6">
    <div class="flex items-center gap-4 mb-4">
        <span aria-hidden="true" class="material-symbols-outlined text-primary">trending_up</span>
        <h3 class="font-h3 text-h3 text-on-surface">{{ 'Trending Now' }}</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        @foreach($trendingArticles->take(3) as $index => $trending)
            <a class="group flex gap-5 items-start focus:outline-none" href="{{ route('article.show', $trending->slug) }}">
                <div class="relative flex-shrink-0">
                    <span class="font-h1 text-[40px] text-outline/10 group-hover:text-secondary/20 transition-colors leading-none font-black italic">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="font-label-caps text-[10px] text-secondary uppercase font-bold tracking-widest">{{ $trending->category->name ?? 'Article' }}</span>
                    <h4 class="font-h3 text-h3 leading-tight group-hover:text-secondary transition-colors line-clamp-2">
                        {{ $trending->title }}
                    </h4>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif
