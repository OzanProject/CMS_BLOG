{{-- AdSense/Adsterra Slot --}}
@php
    $adstraActive = ($settings['adsterra_active'] ?? '0') === '1';
    $sidebarAdHtml = $adstraActive && !empty($settings['adsterra_banner_300x250_script'])
                        ? $settings['adsterra_banner_300x250_script']
                        : ($settings['ad_sidebar_script'] ?? null);
    $hasAdSense = ($settings['adsense_active'] ?? '0') === '1' && !empty($settings['adsense_client_id']);
@endphp

@if($sidebarAdHtml)
<div class="border border-surface-variant rounded bg-surface p-4 text-center">
    <span aria-hidden="true" class="font-label-caps text-[10px] text-outline tracking-wider uppercase mb-2 block">Advertisement</span>
    <div aria-label="Advertisement Space" class="h-[250px] bg-surface-container-low flex items-center justify-center text-on-surface-variant font-meta overflow-hidden">
        {!! $sidebarAdHtml !!}
    </div>
</div>
@elseif($hasAdSense)
<div class="border border-surface-variant rounded bg-surface p-4 text-center">
    <span aria-hidden="true" class="font-label-caps text-[10px] text-outline tracking-wider uppercase mb-2 block">Advertisement</span>
    <ins class="adsbygoogle" style="display:block;min-height:250px"
         data-ad-client="{{ $settings['adsense_client_id'] }}"
         data-ad-slot="auto" data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
@endif

{{-- Newsletter Widget --}}
<div class="bg-gradient-to-br from-slate-900 to-blue-900 text-white rounded-xl p-8 shadow-premium border border-white/10">
    <div class="flex items-center gap-3 mb-4 text-white">
        <span aria-hidden="true" class="material-symbols-outlined text-[32px] text-blue-400">mark_email_unread</span>
        <h3 class="font-h3 text-h3 leading-none">{{ 'The Briefing' }}</h3>
    </div>
    <p class="font-body-md text-body-md mb-6 opacity-80 text-blue-100">
        {{ 'Expert analysis delivered to your inbox every Tuesday.' }}
    </p>
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
        @csrf
        <label class="sr-only" for="newsletter-email">Your email address</label>
        <input class="w-full bg-surface text-on-surface px-4 py-3 rounded border border-transparent focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta placeholder-outline" id="newsletter-email" name="email" placeholder="{{ 'Your email address' }}" required type="email">
        <button class="w-full bg-secondary text-on-secondary font-label-caps text-label-caps uppercase py-3 rounded hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary" type="submit">{{ 'Subscribe Now' }}</button>
    </form>
</div>

{{-- Trending Sidebar --}}
@if(isset($trendingArticles) && $trendingArticles->count() > 3)
<div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant shadow-premium">
    <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
        <span class="material-symbols-outlined text-secondary">local_fire_department</span>
        {{ 'Most Read' }}
    </h4>
    <div class="space-y-5">
        @foreach($trendingArticles->skip(3)->take(4) as $index => $trend)
            <a href="{{ route('article.show', $trend->slug) }}" class="group flex gap-4">
                <span class="font-h2 text-[28px] font-bold text-outline/30 group-hover:text-secondary/50 transition-colors leading-none pt-1">
                    {{ str_pad($index + 4, 2, '0', STR_PAD_LEFT) }}
                </span>
                <div>
                    <h5 class="font-meta text-[14px] font-semibold text-on-surface group-hover:text-secondary transition-colors leading-snug">
                        {{ Str::limit($trend->title, 60) }}
                    </h5>
                    <p class="text-[12px] text-outline mt-1">{{ $trend->category->name ?? '' }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif
