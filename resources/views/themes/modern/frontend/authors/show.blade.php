@extends('themes.modern.frontend.layouts.app')

@section('title', $user->name . ' - ' . ($settings['site_name'] ?? 'The Editorial Authority'))

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12">
    <!-- Author Profile Header -->
    <div class="mb-16 bg-surface-container-low p-12 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col md:flex-row items-center gap-12">
        <div class="w-48 h-48 bg-surface-container-highest rounded-full shadow-2xl flex items-center justify-center overflow-hidden border-4 border-white px-2">
            @if($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
            @else
                <span class="material-symbols-outlined text-6xl text-outline-variant">person</span>
            @endif
        </div>
        <div class="flex-1 text-center md:text-left">
            <span class="text-[0.6875rem] font-bold tracking-[0.3em] uppercase text-secondary mb-2 block">Contributing Investigative Journalist</span>
            <h1 class="text-5xl font-headline font-bold text-on-surface mb-4">{{ $user->name }}</h1>
            @if($user->bio)
                <p class="text-on-surface-variant font-body text-xl max-w-3xl leading-relaxed">
                    {{ $user->bio }}
                </p>
            @endif
            <div class="flex items-center justify-center md:justify-start gap-8 mt-8 pt-8 border-t border-outline-variant/10">
                <div class="text-center md:text-left">
                    <span class="block text-2xl font-headline font-bold text-on-surface">{{ $articles->total() }}</span>
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Total Investigations</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Author Articles -->
    <div class="mb-12 border-l-4 border-secondary pl-6">
        <h2 class="text-3xl font-headline font-bold text-on-surface">Stories by {{ $user->name }}</h2>
    </div>

    @if($articles->isEmpty())
        <div class="py-24 text-center">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">newspaper</span>
            <h3 class="text-2xl font-headline font-bold text-on-surface">No stories published by this author yet.</h3>
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
                            <span>Analysis published on</span>
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
