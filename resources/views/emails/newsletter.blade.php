<x-mail::message>
# {{ $subject }}

{!! nl2br(e($body)) !!}

<br>
Thanks,<br>
{{ config('app.name') }}

<small>You are receiving this email because you subscribed to our newsletter.</small>
</x-mail::message>
