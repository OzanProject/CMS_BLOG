@extends('layouts.frontend')

@section('meta_title', 'Search: ' . $query . ' - ' . ($settings['site_name'] ?? 'DeepBlog'))
@section('meta_description', 'Search results for ' . $query)

@section('content')
<div class="pd-top-75 pd-bottom-50">
    <div class="container">
        <div class="section-title">
            <h6 class="title">{{ __('frontend.search_results') }} "{{ $query }}"</h6>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Articles Grid -->
                <div class="row">
                    @forelse($articles as $post)
                    <div class="col-lg-6 col-md-6">
                         <div class="single-post-wrap style-overlay">
                            <div class="thumb">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-dark" style="height: 200px; width: 100%;">
                                        <i class="fa fa-newspaper-o text-white-50 fa-2x"></i>
                                    </div>
                                @endif
                                @if($post->category)
                                <a class="tag-base tag-blue" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a>
                                @endif
                            </div>
                            <div class="details">
                                <div class="post-meta-single">
                                    <p><i class="fa fa-clock-o"></i>{{ $post->created_at->format('M d, Y') }}</p>
                                </div>
                                <h6 class="title"><a href="{{ route('article.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a></h6>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-warning">
                            {{ __('frontend.no_results', ['query' => $query]) }}
                        </div>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $articles->appends(['q' => $query])->links('pagination::bootstrap-5') }}
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
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 80px; width: 80px;">
                                <i class="fa fa-file-text-o text-secondary fa-lg"></i>
                            </div>
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
