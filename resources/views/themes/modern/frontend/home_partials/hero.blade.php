@if($heroArticle)
<section class="mb-16 mt-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center bg-surface-container-lowest p-8 lg:p-12 rounded-[2rem] border border-outline-variant/30 shadow-premium">
        
        {{-- Text Content --}}
        <div class="lg:col-span-7 flex flex-col items-start gap-6">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-secondary-container/10 text-secondary border border-secondary/20">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                </span>
                <span class="font-label-caps text-[11px] uppercase tracking-wider font-bold">
                    {{ $heroArticle->is_featured ? 'Featured Analysis' : ($heroArticle->category->name ?? 'Latest Editorial') }}
                </span>
            </div>

            <h1 class="font-h1 text-h1 text-on-surface leading-[1.1] tracking-tight hover:text-secondary transition-colors duration-300">
                <a href="{{ route('article.show', $heroArticle->slug) }}">
                    {{ $heroArticle->title }}
                </a>
            </h1>

            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl leading-relaxed">
                {{ Str::limit(strip_tags($heroArticle->content), 160) }}
            </p>

            <div class="flex flex-wrap items-center gap-6 font-meta text-meta text-outline">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                    </div>
                    <span class="font-bold text-on-surface">By {{ $heroArticle->user->name ?? 'Admin' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>{{ $heroArticle->published_at->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                    <span>{{ number_format($heroArticle->views) }} views</span>
                </div>
            </div>

            <a href="{{ route('article.show', $heroArticle->slug) }}" class="mt-4 inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-xl font-label-caps text-sm uppercase tracking-widest hover:bg-secondary hover:shadow-premium-hover transition-all duration-300 group">
                Read Full Story
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>

        {{-- Hero Image --}}
        <div class="lg:col-span-5 relative group">
            <div class="absolute -inset-4 bg-secondary/5 rounded-[2rem] blur-2xl group-hover:bg-secondary/10 transition-all duration-500"></div>
            <div class="relative h-[350px] lg:h-[450px] rounded-[1.5rem] overflow-hidden shadow-2xl bg-surface-container-high border border-white/20">
                @if($heroArticle->featured_image)
                    <img alt="{{ $heroArticle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="{{ asset('storage/' . $heroArticle->featured_image) }}">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-surface-container-high to-surface-container text-outline">
                        <span class="material-symbols-outlined text-[80px] mb-4 opacity-20">article</span>
                        <span class="font-meta text-sm opacity-40 italic">Premium Article</span>
                    </div>
                @endif
                
                {{-- Decorative element --}}
                <div class="absolute top-0 right-0 p-6">
                    <div class="bg-white/20 backdrop-blur-md p-3 rounded-2xl border border-white/30">
                        <span class="material-symbols-outlined text-white text-[24px]">auto_awesome</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
