@if(isset($settings['ad_header_script']) && !empty($settings['ad_header_script']))
    {!! $settings['ad_header_script'] !!}
@elseif(isset($settings['ad_header_image']))
    <a href="{{ $settings['ad_header_url'] ?? '#' }}" target="_blank">
        <img src="{{ asset('storage/' . $settings['ad_header_image']) }}" alt="Advertisement" class="img-fluid">
    </a>
@else
    <a href="#" class="d-block text-center" style="background: #f8f9fa; border: 2px dashed #ddd; padding: 20px 0;">
        <h6 class="text-muted m-0 text-uppercase" style="letter-spacing: 2px;">Header Ad Spot (728x90)</h6>
    </a>
@endif
