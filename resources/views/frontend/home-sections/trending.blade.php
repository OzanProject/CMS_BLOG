                <div class="col-lg-3 col-md-6">
                    <div class="section-title">
                        <h6 class="title">Trending News</h6>
                    </div>
                    <div class="post-slider owl-carousel">
                        @if(isset($trendingArticles) && $trendingArticles->count() > 0)
                            @foreach($trendingArticles->chunk(3) as $chunk)
                            <div class="item">
                                @foreach($chunk as $post)
                                <div class="trending-post">
                                    <div class="single-post-wrap style-overlay">
                                        <div class="thumb">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img">
                                            @else
                                                <img src="{{ asset('nextpage-lite/assets/img/post/5.png') }}" alt="img">
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
                        @else
                            <!-- Fallback Trending -->
                            <div class="item">
                                @for($i=5; $i<=7; $i++)
                                <div class="trending-post">
                                    <div class="single-post-wrap style-overlay">
                                        <div class="thumb">
                                            <img src="{{ asset('nextpage-lite/assets/img/post/'.$i.'.png') }}" alt="img">
                                        </div>
                                        <div class="details">
                                            <div class="post-meta-single">
                                                <p><i class="fa fa-clock-o"></i>{{ date('M d, Y') }}</p>
                                            </div>
                                            <h6 class="title"><a href="#">Sample Trending News {{ $i }}</a></h6>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
