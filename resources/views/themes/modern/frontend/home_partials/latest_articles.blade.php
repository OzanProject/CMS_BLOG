<div class="flex items-center justify-between mb-8 pb-2 border-b border-surface-variant">
    <h2 class="font-h2 text-h2 text-on-surface border-l-4 border-secondary-container pl-3">{{ 'Latest Editorials' }}</h2>
    <a class="font-label-caps text-label-caps uppercase text-secondary hover:underline focus:outline-none focus:ring-2 focus:ring-secondary rounded px-1" href="{{ route('article.index') }}">View All</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    @foreach($latestArticles as $article)
        @include('themes.modern.frontend.layouts.partials.article_card')
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-12 flex justify-center">
    {{ $latestArticles->links('themes.modern.frontend.layouts.partials.pagination') }}
</div>
