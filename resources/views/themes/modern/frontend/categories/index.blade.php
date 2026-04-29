@extends('themes.modern.frontend.layouts.app')

@section('title', 'Kategori Artikel Teknologi, Laravel & Programming — ' . ($settings['site_name'] ?? 'TechJournal'))

@section('seo_meta')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@' }}type": "CollectionPage",
  "name": "Kategori Artikel {{ $settings['site_name'] ?? 'TechJournal' }}",
  "description": "Jelajahi kumpulan kategori artikel teknologi, Laravel, web development, dan programming terbaru.",
  "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')
<main class="max-w-[1200px] mx-auto px-6 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-8 flex items-center text-sm font-meta text-on-surface-variant">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-semibold">{{ 'Semua Kategori' }}</span>
    </nav>

    {{-- Page Header (SEO Optimized) --}}
    <header class="mb-12 border-l-4 border-secondary-container pl-6">
        <h1 class="font-h1 text-h1 text-on-surface mb-3 leading-tight">
            Kategori Artikel Teknologi, Laravel & Programming
        </h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
            Temukan berbagai kategori artikel seputar Laravel, programming, AI, web development, dan teknologi terbaru untuk meningkatkan skill coding Anda dan membangun aplikasi profesional.
        </p>
    </header>

    {{-- AdSense Slot (High Traffic Placement) --}}
    @if(($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
    <div class="mb-12 py-4 flex justify-center border-y border-outline-variant/30 bg-surface-container-low rounded-xl px-4">
        <div class="text-center w-full max-w-[728px]">
            <span class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest block mb-3">Advertisement</span>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="auto"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    </div>
    @endif

    {{-- Categories Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $cat)
            <article class="group relative bg-surface-container-lowest border border-outline-variant rounded-xl p-8 hover:bg-white hover:border-secondary/30 transition-all duration-300 hover:shadow-[0_12px_24px_rgba(33,112,228,0.08)] hover:-translate-y-1 flex flex-col h-full">
                <div class="flex justify-between items-start mb-6">
                    <span class="font-label-caps text-[11px] tracking-widest uppercase text-secondary font-bold">
                        {{ $cat->articles_count ?? 0 }} {{ 'Articles' }}
                    </span>
                    @if(($cat->articles_count ?? 0) > 10)
                        <span class="text-[10px] font-bold bg-secondary text-white px-2.5 py-1 rounded-full uppercase tracking-tighter">
                            Popular
                        </span>
                    @endif
                </div>

                <h3 class="font-h2 text-2xl text-on-surface group-hover:text-secondary transition-colors leading-tight mb-4 flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary/40 group-hover:text-secondary transition-colors">folder</span>
                    <a href="{{ route('category.show', $cat->slug) }}" class="stretched-link">{{ $cat->name }}</a>
                </h3>

                @if($cat->description)
                    <p class="font-body-md text-[16px] text-on-surface-variant line-clamp-3 mb-8 flex-grow leading-relaxed">
                        {{ $cat->description }}
                    </p>
                @endif

                <div class="flex items-center gap-2 font-label-caps text-[11px] uppercase tracking-widest text-secondary font-bold group-hover:gap-4 transition-all">
                    <span>Jelajahi Artikel {{ $cat->name }}</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Bottom AdSense Slot (Optional) --}}
    @if(($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']))
    <div class="mt-16 text-center">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ $settings['adsense_client_id'] }}"
             data-ad-slot="auto"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
    @endif

</main>

<style>
    .stretched-link::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        content: "";
    }
</style>
@endsection
