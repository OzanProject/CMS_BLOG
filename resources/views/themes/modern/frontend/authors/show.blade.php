@extends('themes.modern.frontend.layouts.app')

@section('title', $user->name . ' — ' . ($settings['site_name'] ?? 'TechJournal'))

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-medium">{{ $user->name }}</span>
    </nav>

    {{-- Author Header --}}
    <div class="mb-12 flex items-center gap-6 p-8 bg-surface-container-lowest rounded-xl border border-surface-variant">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=0058be&background=d8e2ff&bold=true&size=128"
             class="w-20 h-20 rounded-full border-2 border-secondary/20"
             alt="{{ $user->name }}">
        <div>
            <h1 class="font-h2 text-h2 text-on-surface mb-1">{{ $user->name }}</h1>
            <p class="font-meta text-meta text-outline">
                {{ $articles->total() }} {{ 'articles published' }}
            </p>
            @if($user->bio ?? false)
                <p class="font-body-md text-body-md text-on-surface-variant mt-3 max-w-content-max">{{ $user->bio }}</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Articles Grid --}}
        <div class="lg:col-span-8">
            <div class="flex items-center justify-between mb-8 pb-2 border-b border-surface-variant">
                <h2 class="font-h2 text-h2 text-on-surface border-l-4 border-secondary-container pl-3">Articles by {{ $user->name }}</h2>
            </div>

            @if($articles->isEmpty())
                <div class="text-center py-20">
                    <span class="material-symbols-outlined text-[64px] text-outline mb-4">edit_note</span>
                    <h3 class="font-h3 text-h3 text-on-surface mb-2">No articles yet</h3>
                    <p class="text-on-surface-variant font-meta">This author hasn't published any articles yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($articles as $article)
                        <article class="bg-surface-container-lowest rounded-xl overflow-hidden group transition-all duration-300 hover:shadow-[0_16px_32px_-12px_rgba(0,0,0,0.08)] relative focus-within:ring-2 focus-within:ring-secondary">
                            <a aria-label="Read article: {{ $article->title }}" class="absolute inset-0 z-10" href="{{ route('article.show', $article->slug) }}"></a>
                            <div class="h-48 bg-surface-variant overflow-hidden relative">
                                @if($article->featured_image)
                                    <img alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $article->featured_image) }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                                        <span class="material-symbols-outlined text-[48px] text-outline">article</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3 relative z-20">
                                    <a class="inline-block px-2 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-caps text-label-caps uppercase hover:opacity-80" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
                                    <span class="font-meta text-meta text-outline">{{ $article->published_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="font-h3 text-h3 text-on-surface mb-3 group-hover:text-secondary transition-colors line-clamp-2">{{ $article->title }}</h3>
                                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 space-y-8">
            {{-- Recent Articles by Author --}}
            @if(isset($recentArticles) && $recentArticles->isNotEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant sticky top-24">
                <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">schedule</span>
                    {{ 'Recent Articles' }}
                </h4>
                <div class="space-y-5">
                    @foreach($recentArticles->take(5) as $index => $recent)
                        <a href="{{ route('article.show', $recent->slug) }}" class="group flex gap-4">
                            <span class="font-h2 text-[24px] font-bold text-outline/30 group-hover:text-secondary/50 transition-colors leading-none pt-1">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div>
                                <h5 class="font-meta text-[14px] font-semibold text-on-surface group-hover:text-secondary transition-colors leading-snug">
                                    {{ Str::limit($recent->title, 55) }}
                                </h5>
                                <p class="text-[11px] text-outline mt-1">{{ $recent->published_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>
    </div>
</div>
@endsection
