@props(['url', 'logo' => null])
@php
    $siteName = \App\Models\Configuration::where('key', 'site_name')->value('value') ?? config('app.name');
@endphp
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if ($logo)
<img src="{{ $logo }}" class="logo" alt="{{ $siteName }}">
@else
<h1 style="color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; margin: 0;">{{ $siteName }}</h1>
@endif
</a>
</td>
</tr>
