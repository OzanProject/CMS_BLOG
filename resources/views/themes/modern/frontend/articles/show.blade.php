@extends('themes.modern.frontend.layouts.app')

@section('title', ($article->meta_title ?? $article->title) . ' — ' . ($settings['site_name'] ?? 'TechJournal'))
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 160))
@section('meta_keywords', $article->keywords ?? '')
@section('meta_image', !empty($article->featured_image) ? asset('storage/' . $article->featured_image) : '')

@push('styles')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ addslashes($article->title ?? '') }}",
  "image": ["{{ !empty($article->featured_image) ? asset('storage/' . $article->featured_image) : '' }}"],
  "datePublished": "{{ isset($article->published_at) ? $article->published_at->toIso8601String() : '' }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ addslashes($article->user->name ?? 'Admin') }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ addslashes($settings['site_name'] ?? 'TechJournal') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '' }}"
    }
  },
  "description": "{{ addslashes(Str::limit(strip_tags($article->content ?? ''), 160)) }}"
}
</script>
@endpush

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- ===== MAIN ARTICLE COLUMN ===== --}}
        <article class="lg:col-span-8">

            {{-- Breadcrumbs --}}
            <nav aria-label="Breadcrumb" class="mb-8 flex items-center text-sm font-meta text-outline">
                <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
                @if(isset($article->category))
                    <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
                    <a class="hover:text-primary transition-colors" href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
                @endif
                <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
                <span aria-current="page" class="text-on-surface font-medium truncate max-w-[250px]">{{ Str::limit($article->title, 40) }}</span>
            </nav>

            {{-- Category Badge --}}
            @if(isset($article->category))
            <div class="inline-block px-3 py-1 mb-4 rounded bg-secondary-fixed text-on-secondary-fixed font-label-caps text-label-caps uppercase">
                {{ $article->category->name }}
            </div>
            @endif

            {{-- Headline --}}
            <h1 class="font-h1 text-h1 text-on-surface mb-6 leading-tight">{{ $article->title }}</h1>

            {{-- Author & Meta --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-5 border-y border-surface-variant mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'Admin') }}&color=0058be&background=d8e2ff&bold=true&size=80"
                         class="w-11 h-11 rounded-full border border-secondary/20"
                         alt="{{ $article->user->name ?? 'Author' }}">
                    <div>
                        <a href="{{ route('author.show', Str::slug($article->user->name ?? 'admin')) }}" class="font-meta font-semibold text-on-surface hover:text-secondary transition-colors">
                            By {{ $article->user->name ?? 'Admin' }}
                        </a>
                        <p class="text-[12px] text-outline font-meta">{{ $article->published_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 font-meta text-meta text-outline">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        {{ number_format($article->views) }} views
                    </span>
                </div>
            </div>

            {{-- Featured Image --}}
            @if(!empty($article->featured_image))
            <figure class="mb-10">
                <div class="rounded-xl overflow-hidden bg-surface-container shadow-sm">
                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                         alt="{{ $article->title }}"
                         class="w-full h-auto object-cover"
                         loading="eager">
                </div>
            </figure>
            @endif

            {{-- Article Body --}}
            <div class="article-content font-body-md text-body-md text-on-surface-variant leading-relaxed">
                @if(class_exists('\App\Helpers\ContentInjector'))
                    {!! \App\Helpers\ContentInjector::inject($article->content, $settings) !!}
                @else
                    {!! $article->content !!}
                @endif
            </div>

            {{-- Tags --}}
            @if($article->tags && $article->tags->isNotEmpty())
            <div class="mt-10 pt-6 border-t border-surface-variant flex flex-wrap gap-2">
                @foreach($article->tags as $tag)
                    <span class="px-3 py-1.5 bg-surface-container text-on-surface-variant text-[11px] font-label-caps uppercase rounded-full border border-surface-variant">
                        # {{ $tag->name }}
                    </span>
                @endforeach
            </div>
            @elseif(!empty($article->keywords))
            <div class="mt-10 pt-6 border-t border-surface-variant flex flex-wrap gap-2">
                @foreach(array_filter(array_map('trim', explode(',', $article->keywords))) as $keyword)
                    <span class="px-3 py-1.5 bg-surface-container text-on-surface-variant text-[11px] font-label-caps uppercase rounded-full border border-surface-variant">
                        # {{ $keyword }}
                    </span>
                @endforeach
            </div>
            @endif

            {{-- Share Buttons --}}
            <div class="mt-8 pt-6 border-t border-surface-variant">
                <h4 class="font-label-caps text-label-caps uppercase text-outline mb-4">Share this article</h4>
                <div class="flex gap-3">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer"
                       class="px-4 py-2 rounded bg-surface-container hover:bg-primary hover:text-on-primary text-on-surface-variant text-sm font-meta transition-all">
                        Twitter/X
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer"
                       class="px-4 py-2 rounded bg-surface-container hover:bg-secondary hover:text-on-secondary text-on-surface-variant text-sm font-meta transition-all">
                        Facebook
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer"
                       class="px-4 py-2 rounded bg-surface-container hover:bg-green-600 hover:text-white text-on-surface-variant text-sm font-meta transition-all">
                        WhatsApp
                    </a>
                </div>
            </div>

            {{-- Comments Section --}}
            <section class="mt-12 pt-8 border-t border-surface-variant">
                <h3 class="font-h3 text-h3 text-on-surface mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">forum</span>
                    {{ __('frontend.comments') ?? 'Comments' }}
                    <span class="text-outline text-[16px]">({{ $article->comments->count() }})</span>
                </h3>

                {{-- Display Comments --}}
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

                        {{-- Child Comments --}}
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
                    <p class="text-outline font-meta italic mb-8">{{ __('frontend.no_comments') ?? 'No comments yet. Be the first!' }}</p>
                @endforelse

                {{-- Comment Form --}}
                <div class="mt-8 p-6 rounded-xl bg-surface-container-lowest border border-surface-variant">
                    <h4 class="font-h3 text-[18px] text-on-surface mb-5">{{ __('frontend.leave_comment') ?? 'Leave a Comment' }}</h4>
                    <form action="{{ route('article.comment', $article->slug) }}" method="POST" class="space-y-4">
                        @csrf
                        {{-- Honeypot --}}
                        <input type="text" name="website_catch" class="hidden" tabindex="-1" autocomplete="off">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-meta text-[12px] text-on-surface-variant mb-1 uppercase tracking-wider" for="comment-name">{{ __('frontend.name') ?? 'Name' }} *</label>
                                <input id="comment-name" name="name" type="text" required value="{{ old('name') }}"
                                    class="w-full bg-surface px-4 py-3 rounded border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline">
                            </div>
                            <div>
                                <label class="block font-meta text-[12px] text-on-surface-variant mb-1 uppercase tracking-wider" for="comment-email">{{ __('frontend.email') ?? 'Email' }} *</label>
                                <input id="comment-email" name="email" type="email" required value="{{ old('email') }}"
                                    class="w-full bg-surface px-4 py-3 rounded border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline">
                            </div>
                        </div>
                        <div>
                            <label class="block font-meta text-[12px] text-on-surface-variant mb-1 uppercase tracking-wider" for="comment-body">{{ __('frontend.comment') ?? 'Comment' }} *</label>
                            <textarea id="comment-body" name="body" rows="4" required
                                class="w-full bg-surface px-4 py-3 rounded border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline resize-none">{{ old('body') }}</textarea>
                        </div>

                        {{-- reCAPTCHA v3 --}}
                        @if(config('services.recaptcha.site_key'))
                            <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
                            <script>
                                grecaptcha.ready(function() {
                                    grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'comment'}).then(function(token) {
                                        document.getElementById('recaptchaResponse').value = token;
                                    });
                                });
                            </script>
                        @endif

                        <button type="submit" class="bg-secondary text-on-secondary px-6 py-3 rounded font-label-caps text-label-caps uppercase hover:opacity-90 transition-opacity">
                            {{ __('frontend.submit_comment') ?? 'Post Comment' }}
                        </button>

                        @if($errors->any())
                            <div class="mt-3 text-error text-sm font-meta">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                    </form>
                </div>
            </section>

            {{-- Related Articles --}}
            @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
            <section class="mt-12 pt-8 border-t border-surface-variant">
                <h3 class="font-h3 text-h3 text-on-surface mb-8 flex items-center gap-3">
                    <span class="w-5 h-[2px] bg-secondary"></span>
                    {{ __('frontend.related_articles') ?? 'Related Articles' }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                    <a href="{{ route('article.show', $rel->slug) }}" class="group block">
                        <div class="aspect-video rounded-xl overflow-hidden bg-surface-container mb-3 border border-surface-variant">
                            @if(!empty($rel->featured_image))
                                <img src="{{ asset('storage/' . $rel->featured_image) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     alt="{{ $rel->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                                    <span class="material-symbols-outlined text-[36px] text-outline">article</span>
                                </div>
                            @endif
                        </div>
                        <span class="text-[11px] font-label-caps text-secondary uppercase tracking-wider">{{ $rel->category->name ?? '' }}</span>
                        <h4 class="font-h3 text-[16px] text-on-surface group-hover:text-secondary leading-snug mt-1 transition-colors line-clamp-2">
                            {{ $rel->title }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

        </article>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-8">

                {{-- Sidebar Ad --}}
                @php
                    $adstraActive2 = ($settings['adsterra_active'] ?? '0') === '1';
                    $sidebarAd2 = $adstraActive2 && !empty($settings['adsterra_banner_300x250_script'])
                                    ? $settings['adsterra_banner_300x250_script']
                                    : ($settings['ad_sidebar_script'] ?? null);
                @endphp

                @if($sidebarAd2)
                <div class="text-center">
                    <p class="font-label-caps text-[10px] text-outline tracking-wider uppercase mb-2">Advertisement</p>
                    <div class="overflow-hidden rounded-xl border border-surface-variant min-h-[250px] flex items-center justify-center bg-surface-container-low">
                        {!! $sidebarAd2 !!}
                    </div>
                </div>
                @endif

                {{-- Most Read / Trending --}}
                @if(isset($trendingArticles) && $trendingArticles->isNotEmpty())
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant">
                    <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">trending_up</span>
                        {{ __('frontend.popular_news') ?? 'Trending Now' }}
                    </h4>
                    <div class="space-y-5">
                        @foreach($trendingArticles->take(5) as $index => $trend)
                        <a href="{{ route('article.show', $trend->slug) }}" class="group flex gap-4">
                            <span class="font-h2 text-[28px] font-bold text-outline/30 group-hover:text-secondary/50 transition-colors leading-none pt-1">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div>
                                <h5 class="font-meta text-[14px] font-semibold text-on-surface group-hover:text-secondary transition-colors leading-snug">
                                    {{ $trend->title }}
                                </h5>
                                <p class="text-[12px] text-outline mt-1">{{ $trend->category->name ?? '' }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Newsletter --}}
                <div class="bg-primary-container rounded-xl p-6 text-on-primary-container">
                    <h4 class="font-h3 text-[18px] text-on-primary mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined">mail</span>
                        Newsletter
                    </h4>
                    <p class="text-[13px] text-on-primary-fixed-variant mb-4 opacity-90">{{ __('frontend.newsletter_desc') ?? 'Get curated analysis in your inbox.' }}</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                        @csrf
                        <input name="email" type="email" placeholder="{{ __('frontend.email') ?? 'your@email.com' }}" required
                               class="w-full bg-surface text-on-surface px-4 py-3 rounded border border-transparent focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-sm placeholder-outline">
                        <button type="submit" class="w-full bg-secondary text-on-secondary font-label-caps text-label-caps uppercase py-3 rounded hover:opacity-90 transition-opacity">
                            Subscribe
                        </button>
                    </form>
                </div>

            </div>
        </aside>

    </div>
</div>
@endsection
