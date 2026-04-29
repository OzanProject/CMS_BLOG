<article class="bg-surface-container-lowest rounded-xl overflow-hidden group transition-all duration-300 shadow-premium hover:shadow-premium-hover relative focus-within:ring-2 focus-within:ring-secondary">
    <a aria-label="Read article: {{ $article->title }}" class="absolute inset-0 z-10" href="{{ route('article.show', $article->slug) }}"></a>
    <div class="h-48 bg-surface-variant overflow-hidden relative">
        @if($article->featured_image)
            <img alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $article->featured_image) }}" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                <span class="material-symbols-outlined text-[48px] text-outline">article</span>
            </div>
        @endif
    </div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-3 relative z-20">
            @if($article->category)
                <a class="inline-block px-2 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-caps text-label-caps uppercase hover:opacity-80" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
            @endif
            <span class="font-meta text-meta text-outline">{{ $article->published_at->diffForHumans() }}</span>
        </div>
        <h3 class="font-h3 text-h3 text-on-surface mb-3 group-hover:text-secondary transition-colors line-clamp-2">
            {{ $article->title }}
        </h3>
        <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">
            {{ Str::limit(strip_tags($article->content), 100) }}
        </p>
    </div>
</article>
