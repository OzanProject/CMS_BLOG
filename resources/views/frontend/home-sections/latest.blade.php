                <div class="col-lg-3 col-md-6">
                    <div class="section-title">
                        <h6 class="title">Latest News</h6>
                    </div>
                    <div class="post-slider owl-carousel">
                        @if(isset($latestArticles) && $latestArticles->count() > 0)
                            @foreach($latestArticles->chunk(4) as $chunk)
                            <div class="item">
                                @foreach($chunk as $post)
                                <div class="single-post-list-wrap">
                                    <div class="media">
                                        <div class="media-left">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img">
                                            @else
                                                <img src="{{ asset('nextpage-lite/assets/img/post/list/1.png') }}" alt="img">
                                            @endif
                                        </div>
                                        <div class="media-body">
                                            <div class="details">
                                                <div class="post-meta-single">
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i>{{ $post->created_at->format('M d, Y') }}</li>
                                                    </ul>
                                                </div>
                                                <h6 class="title"><a href="#">{{ Str::limit($post->title, 40) }}</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        @else
                             <!-- Fallback Latest -->
                            <div class="item">
                                @for($i=1; $i<=4; $i++)
                                <div class="single-post-list-wrap">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{{ asset('nextpage-lite/assets/img/post/list/'.$i.'.png') }}" alt="img">
                                        </div>
                                        <div class="media-body">
                                            <div class="details">
                                                <div class="post-meta-single">
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i>{{ date('M d, Y') }}</li>
                                                    </ul>
                                                </div>
                                                <h6 class="title"><a href="#">Sample Latest News {{ $i }}</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
