@extends('layouts.frontend')

@section('title', $article->meta_title ?? $article->title)
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 150))
@section('meta_keywords', $article->keywords)

@section('content')
<div class="pd-top-75 pd-bottom-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Breadcrumbs -->
                @php
                    $breadcrumbs = [];
                    if($article->category) {
                        $breadcrumbs[$article->category->name] = route('category.show', $article->category->slug);
                    }
                    $breadcrumbs[$article->title] = '#';
                @endphp
                @include('frontend.partials.breadcrumbs', ['links' => $breadcrumbs])

                <div class="single-post-wrap">
                    <div class="thumb">
                        @if($article->featured_image)
                            <img class="w-100" src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                        @endif
                    </div>
                    <div class="details">
                        <div class="post-meta-single mb-4 pt-1">
                            <ul>
                                @if($article->category)
                                <li><a href="{{ route('category.show', $article->category->slug) }}" class="tag-base tag-blue">{{ $article->category->name }}</a></li>
                                @endif
                                
                                @foreach($article->tags as $tag)
                                <li><a href="#" class="tag-base tag-light-blue" style="background: #e3f2fd; color: #1976d2;">{{ $tag->name }}</a></li>
                                @endforeach
                                <li><i class="fa fa-user"></i><a href="{{ route('author.show', $article->user->username ?? Str::slug($article->user->name)) }}" class="text-secondary">{{ $article->user->name }}</a></li>
                                <li><i class="fa fa-clock-o"></i>{{ $article->published_at->translatedFormat('d M Y') }}</li>
                                <li><i class="fa fa-eye"></i>{{ $article->views }} {{ __('frontend.views') }}</li>
                            </ul>
                        </div>
                        <h2 class="title">{{ $article->title }}</h2>
                        
                        <div class="content mt-4">
                            {!! $article->content !!}
                        </div>



                        <!-- Social Share -->
                        <div class="post-meta-single mt-4">
                            <h6 class="mb-3">{{ __('frontend.share_article') }}</h6>
                            <div class="social-share-buttons d-flex flex-wrap">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i> <span class="d-none d-md-inline">Facebook</span></a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-social btn-twitter"><i class="fa fa-twitter"></i> <span class="d-none d-md-inline">Twitter</span></a>
                                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" class="btn btn-social btn-whatsapp"><i class="fa fa-whatsapp"></i> <span class="d-none d-md-inline">WhatsApp</span></a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-social btn-linkedin"><i class="fa fa-linkedin"></i> <span class="d-none d-md-inline">LinkedIn</span></a>
                                <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" class="btn btn-social btn-telegram"><i class="fa fa-telegram"></i> <span class="d-none d-md-inline">Telegram</span></a>
                                <button onclick="copyToClipboard('{{ request()->url() }}')" class="btn btn-social btn-copy"><i class="fa fa-link"></i> <span class="d-none d-md-inline">{{ __('frontend.copy_link') }}</span></button>
                            </div>
                        </div>

                        <style>
                            .social-share-buttons { gap: 10px; }
                            .btn-social { 
                                flex: 1 1 auto; /* Grow to fill space */
                                text-align: center;
                                color: #fff; 
                                border: none; 
                                padding: 10px 15px; 
                                border-radius: 5px; 
                                font-size: 14px; 
                                transition: all 0.3s;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                min-width: 40px; /* Ensure generic icon size */
                            }
                            .btn-social i { margin-right: 5px; font-size: 16px; }
                            .btn-social:hover { opacity: 0.9; color: #fff; transform: translateY(-2px); }
                            
                            /* Mobile Optimization */
                            @media (max-width: 768px) {
                                .btn-social {
                                    padding: 8px 12px;
                                    font-size: 16px; /* Larger icon for touch */
                                }
                                .btn-social i { margin-right: 0; } /* Hide margin if text is hidden */
                                .social-share-buttons { justify-content: space-between; }
                            }

                            .btn-facebook { background-color: #3b5998; }
                            .btn-twitter { background-color: #1da1f2; }
                            .btn-whatsapp { background-color: #25d366; }
                            .btn-linkedin { background-color: #0077b5; }
                            .btn-telegram { background-color: #0088cc; }
                            .btn-copy { background-color: #6c757d; }
                        </style>

                        <script>
                            function copyToClipboard(text) {
                                navigator.clipboard.writeText(text).then(function() {
                                    // Use a simpler alert or toast if possible, standard alert is fine for now
                                    alert('Link copied to clipboard!');
                                }, function(err) {
                                    console.error('Could not copy text: ', err);
                                });
                            }
                        </script>
                    </div>
                    
                    <!-- Related Posts -->
                    @if($relatedArticles->count() > 0)
                    <div class="related-post-area pd-top-50">
                        <div class="section-title">
                            <h6 class="title">{{ __('frontend.related_posts') }}</h6>
                        </div>
                        <div class="row">
                            @foreach($relatedArticles as $related)
                            <div class="col-md-4">
                                <div class="single-post-wrap style-overlay">
                                    <div class="thumb">
                                        @if($related->featured_image)
                                            <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-dark" style="height: 150px; width: 100%;">
                                                <i class="fa fa-newspaper-o text-white-50 fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="details p-3">
                                        <div class="post-meta-single mb-2">
                                            <p class="m-0"><i class="fa fa-clock-o"></i> {{ $related->created_at->translatedFormat('d M Y') }}</p>
                                        </div>
                                        <h6 class="title m-0"><a href="{{ route('article.show', $related->slug) }}">{{ Str::limit($related->title, 40) }}</a></h6>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Comments Section -->
                    @include('frontend.articles.partials.comments')
                    
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="section-title">
                    <h6 class="title">Recent Posts</h6>
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
