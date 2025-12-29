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
                <div class="media-post-wrap-2 media">
                    <div class="thumb">
                        @if($recent->featured_image)
                            <img src="{{ asset('storage/' . $recent->featured_image) }}" alt="{{ $recent->title }}">
                        @endif
                    </div>
                    <div class="media-body">
                        <h6><a href="{{ route('article.show', $recent->slug) }}">{{ Str::limit($recent->title, 50) }}</a></h6>
                        <div class="meta">
                            <span class="date"><i class="fa fa-clock-o"></i>{{ $recent->created_at->format('M d, Y') }}</span>
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
