@php
    $settings = \App\Models\Configuration::pluck('value', 'key');
    $siteName = $settings->get('site_name') ?? config('app.name');
    $siteCopyright = $settings->get('site_copyright') ?? "© " . date('Y') . " " . $siteName;
@endphp
<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
    <div style="margin-bottom: 20px;">
        @if($settings->get('social_facebook'))
            <a href="{{ $settings->get('social_facebook') }}" style="margin: 0 10px; text-decoration: none; color: #b0adc5;">Facebook</a>
        @endif
        @if($settings->get('social_twitter'))
            <a href="{{ $settings->get('social_twitter') }}" style="margin: 0 10px; text-decoration: none; color: #b0adc5;">Twitter</a>
        @endif
        @if($settings->get('social_instagram'))
            <a href="{{ $settings->get('social_instagram') }}" style="margin: 0 10px; text-decoration: none; color: #b0adc5;">Instagram</a>
        @endif
        @if($settings->get('social_youtube'))
            <a href="{{ $settings->get('social_youtube') }}" style="margin: 0 10px; text-decoration: none; color: #b0adc5;">YouTube</a>
        @endif
    </div>
    <div style="font-size: 12px; color: #b0adc5;">
        {{ $siteCopyright }}. All rights reserved.<br>
        {{ $settings->get('contact_address') }}
    </div>
</td>
</tr>
</table>
</td>
</tr>
