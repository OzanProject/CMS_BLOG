                <div class="col-lg-3 col-md-6">
                    <div class="section-title">
                        <h6 class="title">{{ __('frontend.latest_news') }}</h6>
                    </div>
                    <div class="post-slider owl-carousel">
                        @if(isset($latestArticles))
                        @foreach($latestArticles->chunk(4) as $chunk)
                        <div class="item">
                            @foreach($chunk as $post)
                            <div class="single-post-list-wrap">
                                <div class="media">
                                    <div class="media-left">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 80px; width: 80px;">
                                                <i class="fa fa-file-text-o text-secondary fa-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="media-body">
                                        <div class="details">
                                            <div class="post-meta-single">
                                                <ul>
                                                    <li><i class="fa fa-clock-o"></i>{{ $post->created_at->format('M d, Y') }}</li>
                                                </ul>
                                            </div>
                                            <h6 class="title"><a href="{{ route('article.show', $post->slug) }}">{{ Str::limit($post->title, 40) }}</a></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
