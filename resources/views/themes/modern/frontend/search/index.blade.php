@extends('themes.modern.frontend.layouts.app')

@section('title', 'Search results for: ' . $query . ' - ' . ($settings['site_name'] ?? 'The Editorial Authority'))

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-12 border-l-4 border-secondary pl-6 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-[0.6875rem] font-bold tracking-[0.3em] uppercase text-on-surface-variant mb-2 block">Search Investigation</span>
            <h1 class="text-4xl font-headline font-bold text-on-surface mb-2 italic">"{{ $query }}"</h1>
            <p class="text-on-surface-variant font-body">Found {{ $articles->total() }} matching stories in our archives.</p>
        </div>
        
        <form action="{{ route('search') }}" method="GET" class="flex items-center bg-surface-container-highest px-6 py-3 rounded-xl w-full md:w-96">
            <span class="material-symbols-outlined text-on-surface-variant text-lg mr-3">search</span>
            <input name="q" value="{{ $query }}" class="bg-transparent border-none focus:ring-0 text-sm w-full font-body" placeholder="Refine search..." type="text"/>
        </form>
    </div>

    @if($articles->isEmpty())
        <div class="py-24 text-center">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">search_off</span>
            <h3 class="text-2xl font-headline font-bold text-on-surface">No results found for your query.</h3>
            <p class="text-on-surface-variant mt-2 font-body">Try different keywords or browse our categories.</p>
            <a href="{{ url('/') }}" class="inline-block mt-8 bg-black text-white px-8 py-3 rounded-xl font-bold hover:bg-secondary transition-colors">Return Home</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($articles as $article)
                <div class="flex flex-col space-y-6 group cursor-pointer" onclick="window.location='{{ route('article.show', $article->slug) }}'">
                    @if($article->image)
                        <div class="overflow-hidden rounded-xl shadow-lg border border-outline-variant/5">
                            <img class="w-full aspect-video object-cover transition-transform group-hover:scale-105 duration-700" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                        </div>
                    @endif
                    
                    <div class="space-y-4 px-2">
                        <span class="text-[0.6875rem] font-bold tracking-[0.2em] uppercase text-secondary">{{ $article->category->name }}</span>
                        <h3 class="text-3xl font-headline font-bold group-hover:text-secondary transition-colors text-on-surface leading-tight">
                            {{ $article->title }}
                        </h3>
                        <p class="text-on-surface-variant text-base font-body line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <div class="flex items-center gap-3 text-on-surface-variant/60 text-[10px] font-bold uppercase tracking-widest pt-4 border-t border-outline-variant/10">
                            <span>By {{ $article->user->name }}</span>
                            <span class="w-1 h-1 bg-outline-variant rounded-full"></span>
                            <span>{{ $article->published_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16 py-8 border-t border-outline-variant/10">
            {{ $articles->links() }}
        </div>
    @endif
</main>
@endsection
