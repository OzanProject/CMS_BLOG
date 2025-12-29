                <div class="col-lg-3 col-md-6">
                    <div class="section-title">
                        <h6 class="title">{{ __('frontend.trending_news') }}</h6>
                    </div>
                    <div class="post-slider owl-carousel">
                        @if(isset($trendingArticles))
                        @foreach($trendingArticles->chunk(3) as $chunk)
                        <div class="item">
                            @foreach($chunk as $post)
                            <div class="trending-post">
                                <div class="single-post-wrap style-overlay">
                                    <div class="thumb">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-dark" style="height: 120px; width: 100%;">
                                                <i class="fa fa-newspaper-o text-white-50 fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="details">
                                        <div class="post-meta-single">
                                            <p><i class="fa fa-clock-o"></i>{{ $post->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <h6 class="title"><a href="{{ route('article.show', $post->slug) }}">{{ Str::limit($post->title, 40) }}</a></h6>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
