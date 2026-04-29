@extends('themes.modern.frontend.layouts.app')

@section('title', ($article->meta_title ?? $article->title) . ' | ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 160))
@section('meta_keywords', $article->keywords ?? '')
@section('meta_image', !empty($article->featured_image) ? asset('storage/' . $article->featured_image) : '')

@push('styles')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{{ addslashes($article->title ?? '') }}",
  "image": ["{{ !empty($article->featured_image) ? asset('storage/' . $article->featured_image) : '' }}"],
  "datePublished": "{{ isset($article->published_at) ? $article->published_at->toIso8601String() : '' }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": [{"@type": "Person", "name": "{{ addslashes($article->user->name ?? 'Admin') }}", "url": "{{ route('author.show', Str::slug($article->user->name ?? 'admin')) }}"}],
  "publisher": {"@type": "Organization", "name": "{{ addslashes($settings['site_name'] ?? 'TechJournal') }}"},
  "description": "{{ addslashes(Str::limit(strip_tags($article->content ?? ''), 160)) }}"
}
</script>
<style>
    /* Article Typography */
    .article-body p { margin-bottom: 1.75rem; }
    .article-body h2 { font-family: 'Manrope', sans-serif; font-size: 32px; font-weight: 700; line-height: 1.3; letter-spacing: -0.01em; margin-top: 3rem; margin-bottom: 1.5rem; border-left: 4px solid #2170e4; padding-left: 1rem; }
    .article-body h3 { font-family: 'Manrope', sans-serif; font-size: 24px; font-weight: 600; line-height: 1.4; letter-spacing: -0.01em; margin-top: 2.5rem; margin-bottom: 1rem; }
    .article-body blockquote { background: #dae2fd; color: #131b2e; padding: 1.5rem; border-radius: 0.5rem; margin: 2rem 0; border: 1px solid #c6c6cd; }
    .article-body img { width: 100%; border-radius: 0.75rem; margin: 2rem 0; }
    .article-body ul { list-style: disc; padding-left: 1.5rem; margin: 1.5rem 0; }
    .article-body ol { list-style: decimal; padding-left: 1.5rem; margin: 1.5rem 0; }
    .article-body li { margin-bottom: 0.75rem; }
    .article-body ul li::marker { color: #2170e4; }
    .article-body a { color: #0058be; text-decoration: underline; text-underline-offset: 3px; }
    .article-body a:hover { color: #2170e4; }
    .article-body pre { background: #131b2e; color: #bec6e0; padding: 1.25rem; border-radius: 0.5rem; overflow-x: auto; margin: 1.5rem 0; font-size: 0.875rem; }
    .article-body table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; }
    .article-body th, .article-body td { border: 1px solid #e0e3e5; padding: 0.75rem 1rem; text-align: left; }
    .article-body th { background: #f2f4f6; font-family: 'Manrope', sans-serif; font-weight: 600; }
</style>
@endpush

@section('content')
@php
    $readTime = max(1, round(str_word_count(strip_tags($article->content)) / 200));
@endphp
{{-- Reading Progress Bar --}}
<div class="fixed top-16 left-0 w-full h-1 z-[45] bg-transparent">
    <div class="h-full bg-secondary w-0 transition-all duration-150 ease-out" id="progress-bar"></div>
</div>

<main class="pt-[40px] pb-section-gap max-w-container-max mx-auto px-6">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-8 hidden md:block">
        <ol class="flex items-center gap-2 text-meta text-on-surface-variant">
            <li><a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a></li>
            <li><span class="material-symbols-outlined text-[16px]">chevron_right</span></li>
            @if(isset($article->category))
                <li><a class="hover:text-primary transition-colors" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a></li>
                <li><span class="material-symbols-outlined text-[16px]">chevron_right</span></li>
            @endif
            <li aria-current="page" class="text-on-surface truncate max-w-[250px]">{{ Str::limit($article->title, 40) }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">

        {{-- ===== ARTICLE CONTENT (8 Cols) ===== --}}
        <article class="lg:col-span-8" id="article-body">

            {{-- Hero Section --}}
            <header class="mb-12">
                {{-- Meta Pills --}}
                <div class="flex flex-wrap gap-3 mb-6">
                    @if(isset($article->category))
                        <a class="bg-secondary-fixed text-on-secondary-fixed font-label-caps px-3 py-1.5 rounded-full uppercase hover:bg-secondary-fixed-dim transition-colors" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
                    @endif
                    <span class="bg-surface-container text-on-surface-variant font-label-caps px-3 py-1.5 rounded-full uppercase">{{ $readTime }} Min Read</span>
                    @if($article->is_featured)
                        <span class="bg-surface-container text-on-surface-variant font-label-caps px-3 py-1.5 rounded-full uppercase flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">star</span> Featured
                        </span>
                    @endif
                </div>

                {{-- Title --}}
                <h1 class="font-h1 text-h1 text-on-surface mb-6">{{ $article->title }}</h1>

                {{-- Excerpt --}}
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">
                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 200) }}
                </p>

                {{-- Author Bar --}}
                <div class="flex items-center gap-4 mb-8 border-t border-b border-surface-container py-4">
                    <img alt="{{ $article->user->name ?? 'Author' }}" class="w-12 h-12 rounded-full object-cover grayscale"
                         src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'Admin') }}&color=0058be&background=d8e2ff&bold=true&size=96">
                    <div>
                        <p class="font-meta text-meta text-on-surface font-semibold">
                            <a class="hover:text-secondary transition-colors" href="{{ route('author.show', Str::slug($article->user->name ?? 'admin')) }}">{{ $article->user->name ?? 'Admin' }}</a>
                        </p>
                        <p class="font-meta text-[13px] text-on-surface-variant">
                            Published {{ $article->published_at->format('M d, Y') }} · {{ $readTime }} min read · {{ number_format($article->views) }} views
                        </p>
                    </div>
                </div>

                {{-- Featured Image --}}
                @if(!empty($article->featured_image))
                <figure class="mb-10 relative overflow-hidden rounded-xl">
                    <img alt="{{ $article->title }}" class="w-full aspect-[16/9] object-cover" src="{{ asset('storage/' . $article->featured_image) }}" loading="eager">
                </figure>
                @endif
            </header>

            {{-- AdSense / Adsterra: Top Content --}}
            @php
                $adstraActive = ($settings['adsterra_active'] ?? '0') === '1';
                $hasAdSense = ($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']);
            @endphp
            @if($adstraActive && !empty($settings['adsterra_banner_728x90_script']))
                <div class="my-8 flex justify-center">
                    {!! $settings['adsterra_banner_728x90_script'] !!}
                </div>
            @endif

            {{-- Article Body --}}
            <div class="max-w-content-max font-body-md text-body-md text-on-surface leading-relaxed article-body">
                @if(class_exists('\App\Helpers\ContentInjector'))
                    {!! \App\Helpers\ContentInjector::inject($article->content, $settings) !!}
                @else
                    {!! $article->content !!}
                @endif
            </div>

            {{-- AdSense: Bottom Content --}}
            @if($hasAdSense)
            <div class="mt-8 mb-12">
                <ins class="adsbygoogle" style="display:block" data-ad-client="{{ $settings['adsense_client_id'] }}" data-ad-slot="auto" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
            @endif

            {{-- Author Profile Box --}}
            <div class="mt-12 p-6 bg-surface-container-low border border-surface-container rounded-xl flex flex-col sm:flex-row gap-6 items-start">
                <img alt="{{ $article->user->name ?? 'Author' }}" class="w-20 h-20 rounded-full object-cover"
                     src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'Admin') }}&color=0058be&background=d8e2ff&bold=true&size=160">
                <div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-2">{{ $article->user->name ?? 'Admin' }}</h3>
                    <p class="font-body-md text-on-surface-variant mb-4">{{ $article->user->bio ?? 'Author at ' . ($settings['site_name'] ?? 'TechJournal') . '.' }}</p>
                    <div class="flex gap-4">
                        <a class="text-secondary hover:text-secondary-container font-meta text-[14px]" href="{{ route('author.show', Str::slug($article->user->name ?? 'admin')) }}">{{ 'More Articles' }}</a>
                    </div>
                </div>
            </div>

            {{-- Tags & Share --}}
            <footer class="mt-12 pt-8 border-t border-surface-container flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div class="flex flex-wrap gap-2">
                    @if($article->tags && $article->tags->isNotEmpty())
                        @foreach($article->tags as $tag)
                            <span class="bg-surface-container-high text-on-surface font-meta text-[13px] px-3 py-1 rounded hover:bg-surface-variant transition-colors">#{{ $tag->name }}</span>
                        @endforeach
                    @elseif(!empty($article->keywords))
                        @foreach(array_filter(array_map('trim', explode(',', $article->keywords))) as $kw)
                            <span class="bg-surface-container-high text-on-surface font-meta text-[13px] px-3 py-1 rounded hover:bg-surface-variant transition-colors">#{{ $kw }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-label-caps text-on-surface-variant">SHARE:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" aria-label="Share on X" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-secondary hover:text-on-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">share</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on Facebook" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-secondary hover:text-on-secondary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">thumb_up</span>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                    </a>
                    <button aria-label="Copy Link" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center hover:bg-secondary hover:text-on-secondary transition-colors" onclick="navigator.clipboard.writeText(window.location.href);this.querySelector('span').textContent='check';setTimeout(()=>this.querySelector('span').textContent='link',2000)">
                        <span class="material-symbols-outlined text-[18px]">link</span>
                    </button>
                </div>
            </footer>

            {{-- Comments Section --}}
            <section class="mt-16 pt-12 border-t border-surface-container">
                <h3 class="font-h3 text-h3 text-on-surface mb-8 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">forum</span>
                    {{ 'Comments' }} ({{ $article->comments->count() }})
                </h3>

                @forelse($article->comments as $comment)
                    <div class="mb-6 p-5 rounded-xl bg-surface-container-low border border-surface-variant">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name) }}&size=40&background=d8e2ff&color=0058be&bold=true" class="w-8 h-8 rounded-full" alt="">
                            <div>
                                <span class="font-meta font-semibold text-on-surface text-sm">{{ $comment->name }}</span>
                                <span class="text-[11px] text-outline ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <p class="text-on-surface-variant font-body-md text-[16px] leading-relaxed">{{ $comment->body }}</p>
                        @if($comment->children && $comment->children->isNotEmpty())
                            @foreach($comment->children as $reply)
                                <div class="mt-4 ml-8 p-4 rounded-lg bg-surface-container border border-surface-variant">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->name) }}&size=32&background=d8e2ff&color=0058be&bold=true" class="w-6 h-6 rounded-full" alt="">
                                        <span class="font-meta font-semibold text-on-surface text-sm">{{ $reply->name }}</span>
                                        <span class="text-[10px] text-outline">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-on-surface-variant text-[15px] leading-relaxed">{{ $reply->body }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @empty
                    <p class="text-outline font-meta italic mb-8">{{ 'No comments yet. Be the first to share your thoughts!' }}</p>
                @endforelse

                {{-- Comment Form --}}
                <div class="mt-8 p-6 rounded-xl bg-surface-container-lowest border border-outline-variant">
                    <h4 class="font-h3 text-[18px] text-on-surface mb-5">{{ 'Leave a Comment' }}</h4>
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 font-meta text-sm">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('article.comment', $article->slug) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="website_catch" class="hidden" tabindex="-1" autocomplete="off">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-label-caps text-[11px] text-on-surface-variant mb-1.5 uppercase tracking-wider">{{ 'Name' }} *</label>
                                <input name="name" type="text" required value="{{ old('name') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-4 py-2.5 font-meta focus:ring-2 focus:ring-secondary-container outline-none text-on-surface">
                            </div>
                            <div>
                                <label class="block font-label-caps text-[11px] text-on-surface-variant mb-1.5 uppercase tracking-wider">{{ 'Email' }} *</label>
                                <input name="email" type="email" required value="{{ old('email') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-4 py-2.5 font-meta focus:ring-2 focus:ring-secondary-container outline-none text-on-surface">
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-caps text-[11px] text-on-surface-variant mb-1.5 uppercase tracking-wider">{{ 'Comment' }} *</label>
                            <textarea name="body" rows="4" required class="w-full bg-surface-container-lowest border border-outline-variant rounded px-4 py-2.5 font-meta focus:ring-2 focus:ring-secondary-container outline-none text-on-surface resize-none">{{ old('body') }}</textarea>
                        </div>
                        @if(config('services.recaptcha.site_key'))
                            <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
                            <script>grecaptcha.ready(function(){grecaptcha.execute('{{ config('services.recaptcha.site_key') }}',{action:'comment'}).then(function(t){document.getElementById('recaptchaResponse').value=t})});</script>
                        @endif
                        <button type="submit" class="bg-primary text-on-primary font-meta font-semibold px-6 py-2.5 rounded hover:bg-surface-tint transition-colors shadow-sm">{{ 'Post Comment' }}</button>
                        @if($errors->any())
                            <div class="mt-2 text-error text-sm font-meta">
                                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                            </div>
                        @endif
                    </form>
                </div>
            </section>

            {{-- Related Articles --}}
            @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
            <section class="mt-16 pt-12 border-t border-surface-container">
                <h3 class="font-h3 text-h3 text-on-surface mb-8">{{ 'Related Analysis' }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($relatedArticles as $rel)
                    <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 hover:shadow-[0_4px_16px_rgba(15,23,42,0.08)] transition-all duration-300 group cursor-pointer flex flex-col justify-between h-full" onclick="window.location.href='{{ route('article.show', $rel->slug) }}'">
                        <div>
                            <span class="font-label-caps text-secondary-container mb-3 block">{{ $rel->category->name ?? '' }}</span>
                            <h4 class="font-h3 text-[20px] leading-tight text-on-surface mb-3 group-hover:text-secondary-container transition-colors">
                                <a href="{{ route('article.show', $rel->slug) }}">{{ $rel->title }}</a>
                            </h4>
                            <p class="font-meta text-on-surface-variant line-clamp-2">{{ Str::limit(strip_tags($rel->content), 120) }}</p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

        </article>

        {{-- ===== SIDEBAR (4 Cols) ===== --}}
        <aside class="lg:col-span-4 hidden lg:block sticky top-24 h-fit space-y-10 pl-6 border-l border-surface-container">

            {{-- Sidebar Ad --}}
            @php
                $sidebarAdHtml = $adstraActive && !empty($settings['adsterra_banner_300x250_script'])
                    ? $settings['adsterra_banner_300x250_script']
                    : ($settings['ad_sidebar_script'] ?? null);
            @endphp
            @if($sidebarAdHtml)
            <div class="p-4 border border-outline-variant bg-surface-container-lowest flex flex-col items-center justify-center min-h-[250px] rounded-lg relative">
                <span class="absolute top-2 right-2 font-label-caps text-[10px] text-outline uppercase tracking-widest">Advertisement</span>
                {!! $sidebarAdHtml !!}
            </div>
            @elseif($hasAdSense)
            <div class="p-4 border border-outline-variant bg-surface-container-lowest rounded-lg relative">
                <span class="absolute top-2 right-2 font-label-caps text-[10px] text-outline uppercase tracking-widest">Advertisement</span>
                <ins class="adsbygoogle" style="display:block;min-height:250px" data-ad-client="{{ $settings['adsense_client_id'] }}" data-ad-slot="auto" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
            @endif

            {{-- Trending / Essential Brief --}}
            @if(isset($trendingArticles) && $trendingArticles->isNotEmpty())
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant">
                <h3 class="font-label-caps text-on-surface mb-4 border-b border-surface-container pb-2">{{ 'TRENDING NOW' }}</h3>
                <ul class="space-y-4 font-meta text-on-surface-variant">
                    @foreach($trendingArticles->take(5) as $index => $trend)
                    <li>
                        <a class="hover:text-secondary-container transition-colors flex gap-3 group" href="{{ route('article.show', $trend->slug) }}">
                            <span class="font-h2 text-[20px] font-bold text-outline/30 group-hover:text-secondary/40 transition-colors leading-none pt-0.5">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="leading-snug group-hover:text-on-surface transition-colors">{{ Str::limit($trend->title, 55) }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Newsletter Snippet --}}
            <div class="bg-primary-container text-on-primary-container p-6 rounded-xl">
                <h3 class="font-h3 text-h3 mb-2 text-on-secondary-container">{{ 'The Weekly Signal' }}</h3>
                <p class="font-meta mb-4">{{ 'Deep technical analysis delivered every Tuesday.' }}</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <input name="email" class="w-full bg-surface-container-lowest border-none rounded px-4 py-2 font-meta focus:ring-2 focus:ring-secondary-container outline-none text-on-surface" placeholder="{{ 'Email address' }}" required type="email">
                    <button class="w-full bg-secondary text-on-secondary font-meta font-semibold py-2 rounded hover:bg-secondary-container transition-colors" type="submit">{{ 'Subscribe' }}</button>
                </form>
            </div>

        </aside>
    </div>
</main>

@endsection

@push('scripts')
<script>
window.addEventListener('scroll', () => {
    const el = document.getElementById('article-body');
    if (!el) return;
    const rect = el.getBoundingClientRect();
    const total = el.scrollHeight;
    const scrolled = Math.min(Math.max((-rect.top) / (total - window.innerHeight) * 100, 0), 100);
    document.getElementById('progress-bar').style.width = scrolled + '%';
});
</script>
@endpush
