@php
    $adstraActive   = ($settings['adsterra_active'] ?? '0') === '1';
    $headerAdHtml   = $adstraActive && !empty($settings['adsterra_banner_728x90_script'])
                        ? $settings['adsterra_banner_728x90_script']
                        : ($settings['ad_header_script'] ?? null);
@endphp

@if($headerAdHtml)
    {!! $headerAdHtml !!}
@elseif(isset($settings['ad_header_image']) && !empty($settings['ad_header_image']))
    <a href="{{ $settings['ad_header_url'] ?? '#' }}" target="_blank">
        <img src="{{ asset('storage/' . $settings['ad_header_image']) }}" alt="Advertisement" class="img-fluid">
    </a>
@endif
