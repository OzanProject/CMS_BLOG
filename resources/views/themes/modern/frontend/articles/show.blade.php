@extends('themes.modern.frontend.layouts.app')

@section('title', ($article->meta_title ?? $article->title) . ' | ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 160))
@section('meta_keywords', $article->keywords ?? '')
@section('meta_image', !empty($article->featured_image) ? asset('storage/' . $article->featured_image) : '')

@section('seo_meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $article->meta_title ?? $article->title }}">
    <meta property="og:description" content="{{ $article->meta_description ?? Str::limit(strip_tags($article->content), 160) }}">
    <meta property="og:image" content="{{ !empty($article->featured_image) ? asset('storage/' . $article->featured_image) : '' }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $article->meta_title ?? $article->title }}">
    <meta property="twitter:description" content="{{ $article->meta_description ?? Str::limit(strip_tags($article->content), 160) }}">
    <meta property="twitter:image" content="{{ !empty($article->featured_image) ? asset('storage/' . $article->featured_image) : '' }}">
@endsection

@push('styles')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@' }}type": "BlogPosting",
  "headline": "{{ addslashes($article->title ?? '') }}",
  "datePublished": "{{ $article->published_at->toIso8601String() }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": [{"{{ '@' }}type": "Person", "name": "{{ addslashes($article->user->name ?? 'Admin') }}"}],
  "publisher": {"{{ '@' }}type": "Organization", "name": "{{ addslashes($settings['site_name'] ?? 'TechJournal') }}"},
  "description": "{{ addslashes(Str::limit(strip_tags($article->content ?? ''), 160)) }}"
}
</script>
<style>
.article-body p { margin-bottom: 1.75rem; }
.article-body h2 { font-family:'Manrope',sans-serif;font-size:32px;font-weight:700;line-height:1.3;margin-top:3rem;margin-bottom:1.5rem;border-left:4px solid #2170e4;padding-left:1rem; scroll-margin-top: 100px; }
.article-body h3 { font-family:'Manrope',sans-serif;font-size:24px;font-weight:600;line-height:1.4;margin-top:2.5rem;margin-bottom:1rem; scroll-margin-top: 100px; }
.article-body blockquote { background:#dae2fd;color:#131b2e;padding:1.5rem;border-radius:.5rem;margin:2rem 0;border:1px solid #c6c6cd; }
.article-body img { width:100%;border-radius:.75rem;margin:2rem 0; }
.article-body ul { list-style:disc;padding-left:1.5rem;margin:1.5rem 0; }
.article-body ol { list-style:decimal;padding-left:1.5rem;margin:1.5rem 0; }
.article-body li { margin-bottom:.75rem; }
.article-body ul li::marker { color:#2170e4; }
.article-body a { color:#0058be;text-decoration:underline;text-underline-offset:3px; }
.article-body a:hover { color:#2170e4; }
.article-body pre { background:#131b2e;color:#bec6e0;padding:1.25rem;border-radius:.5rem;overflow-x:auto;margin:1.5rem 0;font-size:.875rem; }
.article-body table { width:100%;border-collapse:collapse;margin:1.5rem 0; }
.article-body th,.article-body td { border:1px solid #e0e3e5;padding:.75rem 1rem;text-align:left; }
.article-body th { background:#f2f4f6;font-family:'Manrope',sans-serif;font-weight:600; }

/* Table of Contents */
#toc-container { background: #f8fafc; border-radius: 12px; padding: 24px; margin-bottom: 40px; border: 1px solid #e2e8f0; }
#toc-container h4 { font-weight: 800; font-size: 14px; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px; color: #64748b; }
#toc-list { list-style: none; padding: 0; margin: 0; }
#toc-list li { margin-bottom: 12px; }
#toc-list a { text-decoration: none; color: #1e293b; font-weight: 500; font-size: 15px; transition: color 0.2s; }
#toc-list a:hover { color: #2170e4; }
#toc-list .toc-h3 { padding-left: 20px; font-size: 14px; }

/* Sticky Share Bar */
@media (min-width: 1400px) {
    .sticky-share { position: fixed; left: calc(50% - 680px); top: 300px; display: flex; flex-direction: column; gap: 12px; z-index: 40; }
    .sticky-share a, .sticky-share button { width: 44px; height: 44px; border-radius: 50%; background: white; border: 1px solid #e2e8f0; display: flex; items-center justify-content: center; color: #64748b; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .sticky-share a:hover, .sticky-share button:hover { background: #2170e4; color: white; border-color: #2170e4; transform: translateY(-2px); }
}
@media (max-width: 1399px) {
    .sticky-share { display: none !important; }
}
</style>
@endpush

@section('content')
@php
    $readTime = max(1, round(str_word_count(strip_tags($article->content)) / 200));
    $adstraActive = ($settings['adsterra_active'] ?? '0') === '1';
    $hasAdSense = ($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']);
    $sidebarAdHtml = $adstraActive && !empty($settings['adsterra_banner_300x250_script'])
        ? $settings['adsterra_banner_300x250_script']
        : ($settings['ad_sidebar_script'] ?? null);
@endphp

{{-- Reading Progress Bar --}}
<div class="fixed top-16 left-0 w-full h-1 z-[45] bg-transparent">
    <div class="h-full bg-secondary w-0 transition-all duration-150 ease-out" id="progress-bar"></div>
</div>

{{-- Sticky Share Bar --}}
<div class="sticky-share">
    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" aria-label="Share on Twitter"><span class="material-symbols-outlined text-[20px]">share</span></a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><span class="material-symbols-outlined text-[20px]">thumb_up</span></a>
    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><span class="material-symbols-outlined text-[20px]">chat</span></a>
    <button onclick="document.getElementById('copy-link-btn').click()" aria-label="Copy Link"><span class="material-symbols-outlined text-[20px]">link</span></button>
</div>

<main class="pt-10 pb-20 max-w-[1200px] mx-auto px-6">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-8 hidden md:block">
        <ol class="flex items-center gap-2 text-sm text-on-surface-variant font-meta">
            <li><a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a></li>
            <li><span class="material-symbols-outlined text-[16px]">chevron_right</span></li>
            @if(isset($article->category))
                <li><a class="hover:text-primary transition-colors" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a></li>
                <li><span class="material-symbols-outlined text-[16px]">chevron_right</span></li>
            @endif
            <li aria-current="page" class="text-on-surface truncate max-w-xs">{{ Str::limit($article->title, 40) }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ARTICLE --}}
        <article class="lg:col-span-8" id="article-body">

            <header class="mb-12">
                {{-- Meta Pills --}}
                <div class="flex flex-wrap gap-3 mb-6">
                    @if(isset($article->category))
                        <a class="bg-secondary-fixed text-on-secondary-fixed font-label-caps px-3 py-1.5 rounded-full uppercase text-xs hover:opacity-80 transition-opacity" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
                    @endif
                    <span class="bg-surface-container text-on-surface-variant font-label-caps px-3 py-1.5 rounded-full uppercase text-xs">{{ $readTime }} Min Read</span>
                    @if(!empty($article->is_featured))
                        <span class="bg-surface-container text-on-surface-variant font-label-caps px-3 py-1.5 rounded-full uppercase text-xs flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">star</span> Featured
                        </span>
                    @endif
                </div>

                {{-- Title --}}
                <h1 class="font-h1 text-h1 text-on-surface mb-6 leading-tight">{{ $article->title }}</h1>

                {{-- Excerpt --}}
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">
                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 200) }}
                </p>

                {{-- Author Bar --}}
                <div class="flex items-center gap-4 mb-8 border-t border-b border-surface-container py-4">
                    @php $authorName = $article->user->name ?? 'Admin'; @endphp
                    <img alt="{{ $authorName }}" class="w-12 h-12 rounded-full object-cover grayscale"
                         src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&color=0058be&background=d8e2ff&bold=true&size=96">
                    <div>
                        <p class="font-meta text-sm text-on-surface font-semibold">
                            <a class="hover:text-secondary transition-colors" href="{{ route('author.show', Str::slug($authorName)) }}">{{ $authorName }}</a>
                        </p>
                        <p class="font-meta text-xs text-on-surface-variant">
                            Published {{ $article->published_at->format('M d, Y') }} &middot; {{ $readTime }} min read &middot; {{ number_format($article->views) }} views
                        </p>
                    </div>
                </div>

                {{-- Featured Image --}}
                @if(!empty($article->featured_image))
                <figure class="mb-10 overflow-hidden rounded-xl shadow-lg">
                    <img alt="{{ $article->title }}" class="w-full aspect-video object-cover" src="{{ asset('storage/' . $article->featured_image) }}" loading="eager">
                </figure>
                @endif
            </header>

            {{-- Table of Contents Placeholder --}}
            <div id="toc-container" class="hidden">
                <h4>Table of Contents</h4>
                <ul id="toc-list"></ul>
            </div>

            {{-- Top Ad --}}
            @if($adstraActive && !empty($settings['adsterra_banner_728x90_script']))
                <div class="my-8 flex justify-center">
                    {!! $settings['adsterra_banner_728x90_script'] !!}
                </div>
            @endif

            {{-- Article Body --}}
            <div class="font-body-md text-body-md text-on-surface leading-relaxed article-body prose-slate max-w-none">
                @if(class_exists('\App\Helpers\ContentInjector'))
                    {!! \App\Helpers\ContentInjector::inject($article->content, $settings, $relatedArticles->shuffle()->first()) !!}
                @else
                    {!! $article->content !!}
                @endif
            </div>

            {{-- Bottom Ad --}}
            @if($hasAdSense)
            <div class="mt-8 mb-12">
                <ins class="adsbygoogle" style="display:block"
                     data-ad-client="{{ $settings['adsense_client_id'] }}"
                     data-ad-slot="auto" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
            @endif

            {{-- Author Box --}}
            <div class="mt-12 p-6 bg-surface-container-low border border-surface-container rounded-xl flex flex-col sm:flex-row gap-6 items-start">
                <img alt="{{ $authorName }}" class="w-20 h-20 rounded-full object-cover flex-shrink-0"
                     src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&color=0058be&background=d8e2ff&bold=true&size=160">
                <div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-2">{{ $authorName }}</h3>
                    <p class="font-body-md text-on-surface-variant mb-4">{{ $article->user->bio ?? 'Author at ' . ($settings['site_name'] ?? 'TechJournal') }}</p>
                    <a class="text-secondary hover:text-secondary-container font-meta text-sm font-bold" href="{{ route('author.show', Str::slug($authorName)) }}">View more from this author &rarr;</a>
                </div>
            </div>

            {{-- Tags & Share --}}
            <footer class="mt-12 pt-8 border-t border-surface-container flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div class="flex flex-wrap gap-2">
                    @if(!empty($article->keywords))
                        @foreach(array_filter(array_map('trim', explode(',', $article->keywords))) as $kw)
                            <span class="bg-surface-container-high text-on-surface font-meta text-xs px-3 py-1 rounded">#{{ $kw }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-label-caps text-xs text-on-surface-variant">SHARE:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}"
                       target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-secondary hover:text-on-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">share</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-secondary hover:text-on-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">thumb_up</span>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                       target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                    </a>
                    <button id="copy-link-btn" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-secondary hover:text-on-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">link</span>
                    </button>
                </div>
            </footer>

            {{-- Comments --}}
            <section class="mt-16 pt-12 border-t border-surface-container">
                <h3 class="font-h3 text-h3 text-on-surface mb-8 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">forum</span>
                    Comments ({{ $article->comments->count() }})
                </h3>

                @forelse($article->comments as $comment)
                    <div class="mb-6 p-5 rounded-xl bg-surface-container-low border border-surface-variant">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name) }}&size=40&background=d8e2ff&color=0058be&bold=true"
                                 class="w-8 h-8 rounded-full" alt="{{ $comment->name }}">
                            <div>
                                <span class="font-meta font-semibold text-on-surface text-sm">{{ $comment->name }}</span>
                                <span class="text-xs text-outline ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <p class="text-on-surface-variant text-base leading-relaxed">{{ $comment->body }}</p>
                        @if($comment->children && $comment->children->isNotEmpty())
                            @foreach($comment->children as $reply)
                                <div class="mt-4 ml-8 p-4 rounded-lg bg-surface-container border border-surface-variant">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->name) }}&size=32&background=d8e2ff&color=0058be&bold=true"
                                             class="w-6 h-6 rounded-full" alt="{{ $reply->name }}">
                                        <span class="font-meta font-semibold text-on-surface text-sm">{{ $reply->name }}</span>
                                        <span class="text-xs text-outline">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-on-surface-variant text-sm leading-relaxed">{{ $reply->body }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @empty
                    <p class="text-outline font-meta italic mb-8">No comments yet. Be the first to share your thoughts!</p>
                @endforelse

                {{-- Comment Form --}}
                <div class="mt-8 p-6 rounded-xl bg-surface-container-lowest border border-outline-variant">
                    <h4 class="font-h3 text-lg text-on-surface mb-5">Leave a Comment</h4>
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('article.comment', $article->slug) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="website_catch" class="hidden" tabindex="-1" autocomplete="off">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-label-caps text-[11px] text-on-surface-variant mb-1.5 uppercase tracking-wider">Name *</label>
                                <input name="name" type="text" required value="{{ old('name') }}"
                                       class="w-full bg-surface-container-lowest border border-outline-variant rounded px-4 py-2.5 font-meta text-sm focus:ring-2 focus:ring-secondary-container outline-none text-on-surface">
                            </div>
                            <div>
                                <label class="block font-label-caps text-[11px] text-on-surface-variant mb-1.5 uppercase tracking-wider">Email *</label>
                                <input name="email" type="email" required value="{{ old('email') }}"
                                       class="w-full bg-surface-container-lowest border border-outline-variant rounded px-4 py-2.5 font-meta text-sm focus:ring-2 focus:ring-secondary-container outline-none text-on-surface">
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-caps text-[11px] text-on-surface-variant mb-1.5 uppercase tracking-wider">Comment *</label>
                            <textarea name="body" rows="4" required
                                      class="w-full bg-surface-container-lowest border border-outline-variant rounded px-4 py-2.5 font-meta text-sm focus:ring-2 focus:ring-secondary-container outline-none text-on-surface resize-none">{{ old('body') }}</textarea>
                        </div>
                        @if($errors->any())
                            <div class="text-red-600 text-sm">
                                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                            </div>
                        @endif
                        <button type="submit" class="bg-primary text-on-primary font-meta text-sm font-semibold px-6 py-2.5 rounded hover:bg-surface-tint transition-colors shadow-sm">Post Comment</button>
                    </form>
                </div>
            </section>

            {{-- Related Articles --}}
            @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
            <section class="mt-16 pt-12 border-t border-surface-container">
                <h3 class="font-h3 text-h3 text-on-surface mb-8">Related Articles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($relatedArticles as $rel)
                    <article class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-6 shadow-premium hover:shadow-premium-hover transition-all duration-300 group">
                        <span class="font-label-caps text-secondary mb-3 block text-[10px] uppercase tracking-widest font-bold">{{ $rel->category->name ?? '' }}</span>
                        <h4 class="font-h3 text-[20px] leading-tight text-on-surface mb-3 group-hover:text-secondary transition-colors line-clamp-2">
                            <a href="{{ route('article.show', $rel->slug) }}">{{ $rel->title }}</a>
                        </h4>
                        <p class="font-body-md text-sm text-on-surface-variant line-clamp-2">{{ Str::limit(strip_tags($rel->content), 120) }}</p>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

        </article>

        {{-- SIDEBAR --}}
        <aside class="lg:col-span-4 hidden lg:block sticky top-24 h-fit space-y-10 pl-6 border-l border-surface-container">

            @if($sidebarAdHtml)
            <div class="p-4 border border-outline-variant bg-surface-container-lowest flex items-center justify-center min-h-[250px] rounded-lg relative">
                <span class="absolute top-2 right-2 font-label-caps text-[10px] text-outline uppercase tracking-widest">Advertisement</span>
                {!! $sidebarAdHtml !!}
            </div>
            @elseif($hasAdSense)
            <div class="p-4 border border-outline-variant bg-surface-container-lowest rounded-lg relative">
                <span class="absolute top-2 right-2 font-label-caps text-[10px] text-outline uppercase tracking-widest">Advertisement</span>
                <ins class="adsbygoogle" style="display:block;min-height:250px"
                     data-ad-client="{{ $settings['adsense_client_id'] }}"
                     data-ad-slot="auto" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
            @endif
            
            {{-- Categories Widget --}}
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/30 shadow-premium">
                <div class="flex flex-col mb-6">
                    <h3 class="font-label-caps text-xs text-on-surface mb-1 tracking-widest uppercase font-bold">Categories</h3>
                    <p class="font-meta text-[11px] text-outline uppercase tracking-wider">Browse by Topic</p>
                </div>
                <div class="space-y-2">
                    @foreach($categories as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="group flex items-center justify-between p-3 rounded-xl border border-transparent hover:border-outline-variant hover:bg-surface-container-low transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-[18px] text-outline group-hover:text-primary transition-colors">folder</span>
                                <span class="font-meta font-bold text-sm text-on-surface-variant group-hover:text-on-surface">{{ $cat->name }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-lg bg-surface-container text-[10px] font-bold text-outline group-hover:bg-primary/10 group-hover:text-primary transition-all">{{ $cat->articles_count ?? $cat->articles()->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            @if(isset($trendingArticles) && $trendingArticles->isNotEmpty())
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/30 shadow-premium">
                <h3 class="font-label-caps text-xs text-on-surface mb-4 border-b border-surface-container pb-2 tracking-widest uppercase font-bold">Trending Now</h3>
                <ul class="space-y-5 font-meta text-on-surface-variant">
                    @foreach($trendingArticles->take(5) as $index => $trend)
                    <li>
                        <a class="flex gap-4 group hover:text-secondary transition-colors items-start" href="{{ route('article.show', $trend->slug) }}">
                            <span class="text-3xl font-bold text-outline/20 group-hover:text-secondary/30 transition-colors leading-none pt-1 flex-shrink-0 italic font-h2">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="flex flex-col gap-1">
                                <span class="text-sm leading-snug group-hover:text-on-surface transition-colors font-semibold">{{ Str::limit($trend->title, 55) }}</span>
                                <span class="font-label-caps text-[9px] text-outline uppercase tracking-widest">{{ $trend->category->name ?? '' }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-gradient-to-br from-slate-900 to-blue-900 text-white p-8 rounded-3xl shadow-premium border border-white/10">
                <h3 class="font-h3 text-xl mb-2 text-white">The Weekly Signal</h3>
                <p class="font-meta text-sm mb-6 text-blue-100 opacity-80 leading-relaxed">Deep technical analysis delivered every Tuesday.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input name="email" type="email" required placeholder="Email address"
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 font-meta text-sm focus:ring-2 focus:ring-blue-400 outline-none text-white placeholder-blue-200/50 transition-all">
                    <button type="submit" class="w-full bg-blue-500 text-white font-label-caps text-xs font-bold py-3.5 rounded-xl hover:bg-blue-400 hover:shadow-lg transition-all uppercase tracking-widest">Subscribe</button>
                </form>
            </div>

        </aside>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Copy Link Logic
    const copyBtn = document.getElementById('copy-link-btn');
    if(copyBtn) {
        copyBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href);
            const icon = this.querySelector('span');
            icon.textContent = 'check';
            setTimeout(() => { icon.textContent = 'link'; }, 2000);
        });
    }

    // 2. Reading Progress
    window.addEventListener('scroll', function() {
        const el = document.getElementById('article-body');
        const progressBar = document.getElementById('progress-bar');
        if (!el || !progressBar) return;
        const rect = el.getBoundingClientRect();
        const total = el.scrollHeight;
        const scrolled = Math.min(Math.max((-rect.top) / (total - window.innerHeight) * 100, 0), 100);
        progressBar.style.width = scrolled + '%';
    });

    // 3. Auto Table of Contents (TOC)
    const articleBody = document.querySelector('.article-body');
    const tocContainer = document.getElementById('toc-container');
    const tocList = document.getElementById('toc-list');
    
    if (articleBody && tocContainer && tocList) {
        const headings = articleBody.querySelectorAll('h2, h3');
        if (headings.length > 2) {
            tocContainer.classList.remove('hidden');
            headings.forEach((heading, index) => {
                const id = 'heading-' + index;
                heading.id = id;
                const li = document.createElement('li');
                li.className = heading.tagName.toLowerCase() === 'h3' ? 'toc-h3' : 'toc-h2';
                const a = document.createElement('a');
                a.href = '#' + id;
                a.textContent = heading.textContent;
                li.appendChild(a);
                tocList.appendChild(li);
            });
        }
    }

    // 4. Lazy Load Images in article body
    const images = document.querySelectorAll('.article-body img, .related-articles img');
    images.forEach(img => {
        if (!img.hasAttribute('loading')) {
            img.setAttribute('loading', 'lazy');
        }
    });
});
</script>
@endpush