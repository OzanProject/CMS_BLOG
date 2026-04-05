@php
    $logo = (isset($logoPath) && file_exists($logoPath)) ? $message->embed($logoPath) : null;
@endphp
<x-mail::message :logo="$logo">
# {{ $subject }}

{!! nl2br(e($body)) !!}

<br>
Best Regards,<br>
**{{ $settings->get('site_name') ?? config('app.name') }}**

<small style="color: #718096; font-size: 11px;">You are receiving this email because you subscribed to our newsletter on our website.</small>
</x-mail::message>
