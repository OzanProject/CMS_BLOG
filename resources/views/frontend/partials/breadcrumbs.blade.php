@if(isset($links) && count($links) > 0)
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('frontend.home') ?? 'Home' }}</a></li>
        @foreach($links as $label => $url)
            @if($loop->last)
                <li class="breadcrumb-item active text-primary" aria-current="page">{{ Str::limit($label, 30) }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $url }}">{{ Str::limit($label, 30) }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>

@php
    $itemListElement = [
        [
            "@type" => "ListItem",
            "position" => 1,
            "name" => __('frontend.home') ?? 'Home',
            "item" => url('/')
        ]
    ];
    
    foreach($links as $label => $url) {
        $itemUrl = $url === '#' ? url()->current() : $url;
        
        $itemListElement[] = [
            "@type" => "ListItem",
            "position" => count($itemListElement) + 1,
            "name" => $label,
            "item" => $itemUrl
        ];
    }

    $schema = [
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList",
        "itemListElement" => $itemListElement
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
