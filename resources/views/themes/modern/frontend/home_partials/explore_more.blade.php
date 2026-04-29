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
