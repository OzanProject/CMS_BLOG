@if(isset($links) && count($links) > 0)
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0 m-0 d-flex flex-wrap align-items-center" style="list-style: none !important;">
        <li class="breadcrumb-item d-inline-flex align-items-center">
            <a href="{{ url('/') }}" class="text-secondary hover-primary transition-all">
                <i class="fa fa-home mr-1"></i> {{ __('frontend.home') ?? 'Home' }}
            </a>
        </li>
        @foreach($links as $label => $url)
            <li class="breadcrumb-item d-inline-flex align-items-center {{ $loop->last ? 'active text-primary font-weight-bold' : '' }}" {{ $loop->last ? 'aria-current=page' : '' }}>
                @if(!$loop->last)
                    <a href="{{ $url }}" class="text-secondary hover-primary transition-all">{{ Str::limit($label, 35) }}</a>
                @else
                    {{ Str::limit($label, 45) }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>

<style>
    .breadcrumb-item + .breadcrumb-item::before {
        content: "\f105"; /* FontAwesome Angle Right */
        font-family: FontAwesome;
        padding: 0 10px;
        color: #adb5bd;
    }
    .breadcrumb-item a { text-decoration: none; }
    .hover-primary:hover { color: #007bff !important; }
    .transition-all { transition: all 0.3s ease; }
</style>

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
