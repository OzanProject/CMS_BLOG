@extends('themes.modern.frontend.layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-12 border-l-4 border-secondary pl-6">
        <h1 class="text-5xl font-headline font-bold text-on-surface mb-2">Editorial Archives</h1>
        <p class="text-on-surface-variant font-body">Exploring the intersection of technology, culture, and business.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($articles as $article)
            <div class="flex flex-col space-y-6 group cursor-pointer" onclick="window.location='{{ route('article.show', $article->slug) }}'">
                @if($article->image)
                    <div class="overflow-hidden rounded-xl shadow-lg">
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
</main>
@endsection
