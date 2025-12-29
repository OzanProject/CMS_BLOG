@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->content), 150))

@section('content')
<div class="pd-top-50 pd-bottom-50">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="single-post-wrap style-no-thumb">
                    <div class="section-title mb-4">
                        <h4 class="title">{{ $page->title }}</h4>
                    </div>
                    <div class="details">
                        <div class="description">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="section-title">
                    <h6 class="title">{{ __('frontend.recent_posts') }}</h6>
                </div>
                @foreach($recentArticles as $recent)
                <div class="media-post-wrap-2 media d-flex align-items-center mb-3">
                    <div class="thumb" style="width: 80px; height: 80px; flex-shrink: 0; overflow: hidden; border-radius: 5px; margin-right: 15px;">
                        @if($recent->featured_image)
                            <img src="{{ asset('storage/' . $recent->featured_image) }}" alt="{{ $recent->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="width: 100%; height: 100%;">
                                <i class="fa fa-file-text-o text-secondary fa-lg"></i>
                            </div>
                        @endif
                    </div>
                    <div class="media-body">
                        <h6 class="m-0" style="line-height: 1.4;"><a href="{{ route('article.show', $recent->slug) }}" class="text-dark">{{ Str::limit($recent->title, 50) }}</a></h6>
                        <div class="meta text-muted small mt-1">
                            <span class="date"><i class="fa fa-clock-o"></i> {{ $recent->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Ad Widget -->
                <div class="widget widget_add mt-4">
                    @include('frontend.partials.ad-sidebar')
                </div>

                <!-- Newsletter Widget -->
                <div class="mt-4">
                    @include('frontend.partials.newsletter-sidebar')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
