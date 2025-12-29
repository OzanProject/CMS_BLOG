<div class="add-area">
    @if(isset($settings['ad_sidebar_script']) && !empty($settings['ad_sidebar_script']))
        {!! $settings['ad_sidebar_script'] !!}
    @elseif(isset($settings['ad_sidebar_image']))
         <a href="{{ $settings['ad_sidebar_url'] ?? '#' }}">
            <img class="w-100" src="{{ asset('storage/' . $settings['ad_sidebar_image']) }}" alt="Advertisement">
        </a>
    @else
        <a href="#" class="d-block w-100 text-center d-flex align-items-center justify-content-center" style="background: #f8f9fa; border: 2px dashed #ddd; min-height: 250px;">
            <h6 class="text-muted m-0 text-uppercase" style="letter-spacing: 2px;">Sidebar Ad</h6>
        </a>
    @endif
</div>
