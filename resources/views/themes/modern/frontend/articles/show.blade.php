@extends('themes.modern.frontend.layouts.app')

@section('title', ($article->title ?? 'Dispatch') . ' — ' . ($settings['site_name'] ?? 'Editorial'))
@section('meta_description', Str::limit(strip_tags($article->content ?? ''), 160))

@push('styles')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ addslashes($article->title ?? '') }}",
  "image": ["{{ isset($article->image) ? asset('storage/' . $article->image) : '' }}"],
  "datePublished": "{{ isset($article->published_at) ? $article->published_at->toIso8601String() : '' }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ addslashes($article->user->name ?? 'Admin') }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ addslashes($settings['site_name'] ?? 'Editorial') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '' }}"
    }
  },
  "description": "{{ addslashes(Str::limit(strip_tags($article->content ?? ''), 160)) }}"
}
</script>
<style>
    .article-content p { margin-bottom: 1.75rem; line-height: 1.9; color: #94a3b8; font-size: 1.0625rem; }
    .article-content h2 { color: #f1f5f9; font-size: 1.6rem; font-weight: 800; margin-top: 3rem; margin-bottom: 1.25rem; font-family: 'Newsreader', Georgia, serif; border-bottom: 1px solid rgba(245,158,11,0.15); padding-bottom: 0.5rem; }
    .article-content h3 { color: #fbbf24; font-size: 1.25rem; font-weight: 700; margin-top: 2.5rem; margin-bottom: 1rem; }
    .article-content blockquote { border-left: 3px solid #f59e0b; padding: 1.25rem 1.75rem; font-style: italic; color: #64748b; margin: 2.5rem 0; background: rgba(245,158,11,0.04); border-radius: 0 0.75rem 0.75rem 0; }
    .article-content img { border-radius: 1.25rem; margin: 2.5rem 0; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5); max-width: 100%; }
    .article-content ul, .article-content ol { padding-left: 1.5rem; margin-bottom: 1.75rem; color: #94a3b8; }
    .article-content ul li, .article-content ol li { margin-bottom: 0.5rem; }
    .article-content a { color: #fbbf24; text-decoration: underline; text-underline-offset: 3px; }
    .article-content a:hover { color: #f59e0b; }
</style>
@endpush

@section('content')
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

        {{-- ===== MAIN ARTICLE COLUMN (8/12) ===== --}}
        <article class="lg:col-span-8">

            {{-- Breadcrumbs --}}
            <nav class="flex items-center gap-2 mb-10 text-[10px] font-black uppercase tracking-[0.2em] text-slate-600">
                <a href="{{ url('/') }}" class="hover:text-amber-500 transition-colors">Home</a>
                @if(isset($article->category))
                    <span>›</span>
                    <a href="{{ route('category.show', $article->category->slug) }}" class="hover:text-amber-500 transition-colors">{{ $article->category->name }}</a>
                @endif
                <span>›</span>
                <span class="text-slate-500 truncate max-w-[200px]">{{ Str::limit($article->title, 40) }}</span>
            </nav>

            {{-- Category Badge --}}
            @if(isset($article->category))
            <span class="bg-amber-500 text-slate-950 px-4 py-1.5 rounded text-[10px] font-black uppercase tracking-widest mb-6 inline-block shadow-[0_0_15px_rgba(245,158,11,0.15)]">
                {{ $article->category->name }}
            </span>
            @endif

            {{-- Headline --}}
            <h1 class="font-headline font-black text-3xl md:text-5xl lg:text-[3.25rem] text-white leading-[1.08] tracking-tight mb-8">
                {{ $article->title }}
            </h1>

            {{-- Author & Meta --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-7 border-y border-slate-900/80 mb-10 gap-4">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'Admin') }}&color=f59e0b&background=0d1117&bold=true&size=80"
                         class="w-12 h-12 rounded-full border border-amber-500/20"
                         alt="{{ $article->user->name ?? 'Author' }}">
                    <div>
                        <p class="font-bold text-white text-sm">By {{ $article->user->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-600 uppercase tracking-widest">{{ $article->published_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    {{ number_format($article->views) }} views
                </div>
            </div>

            {{-- Featured Image --}}
            @if(!empty($article->image))
            <figure class="mb-12">
                <div class="rounded-[1.5rem] overflow-hidden bg-slate-900 border border-slate-800/50 shadow-2xl">
                    <img src="{{ asset('storage/' . $article->image) }}"
                         alt="{{ $article->title }}"
                         class="w-full h-auto object-cover"
                         loading="eager">
                </div>
            </figure>
            @endif

            {{-- Article Body (with in-article ad injection) --}}
            <div class="article-content">
                {!! \App\Helpers\ContentInjector::inject($article->content, $settings) !!}
            </div>

            {{-- Tags --}}
            @if(!empty($article->meta_keywords))
            <div class="mt-12 pt-8 border-t border-slate-900/80 flex flex-wrap gap-2">
                @foreach(array_filter(array_map('trim', explode(',', $article->meta_keywords))) as $tag)
                    <span class="px-3 py-1.5 bg-slate-900 border border-slate-800 text-slate-400 text-[9px] font-bold uppercase rounded tracking-widest">
                        # {{ $tag }}
                    </span>
                @endforeach
            </div>
            @endif

            {{-- Related Articles --}}
            @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
            <section class="mt-16 pt-12 border-t border-slate-900/80">
                <h3 class="font-headline font-black text-xl text-white mb-8 flex items-center gap-4">
                    <span class="w-5 h-[2px] bg-amber-500"></span>
                    Continued Reading
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach($relatedArticles as $rel)
                    <a href="{{ route('article.show', $rel->slug) }}" class="group block">
                        <div class="aspect-video rounded-xl overflow-hidden bg-slate-900 border border-slate-800 mb-4">
                            @if(!empty($rel->image))
                                <img src="{{ asset('storage/' . $rel->image) }}"
                                     class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700"
                                     alt="{{ $rel->title }}">
                            @endif
                        </div>
                        <p class="text-amber-500 text-[9px] font-black uppercase tracking-widest mb-2">{{ $rel->category->name ?? '' }}</p>
                        <h4 class="font-headline font-bold text-base text-slate-300 group-hover:text-white leading-snug transition-colors">
                            {{ $rel->title }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

        </article>

        {{-- ===== SIDEBAR (4/12) ===== --}}
        <aside class="lg:col-span-4">
            <div class="sticky top-24 space-y-10">

                {{-- ═══════════════════════════════════════════════
                     SIDEBAR AD ZONE (300×250 Rectangle)
                     Priority: Adsterra 300x250 → Generic Sidebar → AdSense manual unit
                     ═══════════════════════════════════════════════ --}}
                @php
                    $adstraActive   = ($settings['adsterra_active'] ?? '0') === '1';
                    $sidebarAdHtml  = $adstraActive && !empty($settings['adsterra_banner_300x250_script'])
                                        ? $settings['adsterra_banner_300x250_script']
                                        : ($settings['ad_sidebar_script'] ?? null);
                    $hasAdSense     = ($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']);
                @endphp

                @if($sidebarAdHtml)
                <div class="text-center">
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-700 mb-3">Advertisement</p>
                    <div class="overflow-hidden rounded-xl border border-slate-900/50 min-h-[250px] flex items-center justify-center">
                        {!! $sidebarAdHtml !!}
                    </div>
                </div>
                @elseif($hasAdSense)
                <div class="text-center">
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-700 mb-3">Advertisement</p>
                    <ins class="adsbygoogle"
                         style="display:block;min-height:250px"
                         data-ad-client="{{ $settings['adsense_client_id'] }}"
                         data-ad-slot="auto"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                </div>
                @endif

                {{-- Most Read --}}
                @if(isset($trendingArticles) && $trendingArticles->isNotEmpty())
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-6 pb-3 border-b border-slate-900 flex items-center gap-3">
                        <span class="w-3 h-[2px] bg-amber-500"></span>
                        Essential Brief
                    </h4>
                    <div class="space-y-7">
                        @foreach($trendingArticles->take(5) as $index => $trend)
                        <a href="{{ route('article.show', $trend->slug) }}" class="group flex gap-5">
                            <span class="font-headline text-3xl font-black text-slate-800 group-hover:text-amber-500/40 transition-colors leading-none pt-1">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="space-y-1.5">
                                <h5 class="font-headline font-bold text-sm text-slate-300 group-hover:text-white leading-snug transition-colors">
                                    {{ $trend->title }}
                                </h5>
                                <p class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">
                                    {{ $trend->category->name ?? '' }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Newsletter Widget --}}
                <div class="bg-[#0D1829] border border-amber-500/10 rounded-2xl p-8 relative overflow-hidden">
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl"></div>
                    <h4 class="font-headline font-black text-lg text-white mb-3 relative z-10">Newsletter</h4>
                    <p class="text-slate-500 text-xs mb-6 leading-relaxed">Berita pilihan editorial langsung ke inbox Anda.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3 relative z-10">
                        @csrf
                        <input name="email" type="email" placeholder="alamat@email.com"
                               class="w-full bg-slate-950/80 border border-slate-800 focus:border-amber-500 rounded-lg px-4 py-3 text-sm text-white outline-none transition-all placeholder:text-slate-700"
                               required>
                        <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-black py-3 rounded-lg text-[10px] uppercase tracking-widest transition-colors">
                            Subscribe
                        </button>
                    </form>
                    <p class="mt-4 text-[9px] text-slate-700 text-center uppercase tracking-widest">Berhenti berlangganan kapan saja.</p>
                </div>

            </div>
        </aside>

    </div>
</div>
@endsection
