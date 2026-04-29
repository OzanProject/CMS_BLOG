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
