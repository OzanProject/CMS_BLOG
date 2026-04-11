@php
    $adstraActive   = ($settings['adsterra_active'] ?? '0') === '1';
    $sidebarAdHtml  = $adstraActive && !empty($settings['adsterra_banner_300x250_script'])
                        ? $settings['adsterra_banner_300x250_script']
                        : ($settings['ad_sidebar_script'] ?? null);
@endphp

<div class="add-area">
    @if($sidebarAdHtml)
        {!! $sidebarAdHtml !!}
    @elseif(isset($settings['ad_sidebar_image']) && !empty($settings['ad_sidebar_image']))
         <a href="{{ $settings['ad_sidebar_url'] ?? '#' }}">
            <img class="w-100" src="{{ asset('storage/' . $settings['ad_sidebar_image']) }}" alt="Advertisement">
        </a>
    @endif
</div>
