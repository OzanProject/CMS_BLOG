@extends('layouts.frontend')

@section('meta_title', __('frontend.author_by', ['name' => $user->name]) . ' - ' . ($settings['site_name'] ?? 'DeepBlog'))
@section('meta_description', __('frontend.read_more_author', ['name' => $user->name]))

@section('content')
<div class="pd-top-75 pd-bottom-50">
    <div class="container">
        <div class="section-title">
            <h6 class="title">{{ __('frontend.author') }} {{ $user->name }}</h6>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Articles Grid -->
                <div class="row">
                    @forelse($articles as $post)
                    <div class="col-lg-6 col-md-6">
                         <div class="single-post-wrap style-overlay">
                            <div class="thumb" style="height: 200px; overflow: hidden; border-radius: 5px;">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-dark" style="height: 100%; width: 100%;">
                                        <i class="fa fa-newspaper-o text-white-50 fa-2x"></i>
                                    </div>
                                @endif
                                @if($post->category)
                                <a class="tag-base tag-blue" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a>
                                @endif
                            </div>
                            <div class="details">
                                <div class="post-meta-single">
                                    <p><i class="fa fa-clock-o"></i>{{ $post->created_at->translatedFormat('d M Y') }}</p>
                                </div>
                                <h6 class="title"><a href="{{ route('article.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a></h6>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">{{ __('frontend.no_author_articles') }}</div>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $articles->links('pagination::bootstrap-5') }}
                </div>
                
                <!-- Ad Widget -->
                <div class="widget widget_add mt-4">
                    @include('frontend.partials.ad-sidebar')
                </div>

                <!-- Newsletter Widget -->
                <div class="mt-4">
                    @include('frontend.partials.newsletter-sidebar')
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
                            <span class="date"><i class="fa fa-clock-o"></i> {{ $recent->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Helper for AdSense: Sidebar Ad -->
                <!-- Helper for AdSense: Sidebar Ad -->
                <div class="widget widget_add mt-4">
                    <div class="section-title">
                        <h6 class="title">{{ __('frontend.advertisement') }}</h6>
                    </div>
                    @include('frontend.partials.ad-sidebar')
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
