                <div class="col-lg-3 col-md-6">
                    <div class="section-title">
                        <h6 class="title">{{ __('frontend.whats_new') }}</h6>
                    </div>
                    <div class="post-slider owl-carousel">
                        @if(isset($gridArticles))
                         @foreach($gridArticles as $post)
                        <div class="item">
                            <div class="single-post-wrap">
                                <div class="thumb">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 180px; width: 100%;">
                                            <i class="fa fa-image text-secondary fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="details">
                                    <div class="post-meta-single mb-4 pt-1">
                                        <ul>
                                            @if($post->category)
                                            <li><a class="tag-base tag-blue" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                                            @endif
                                            <li><i class="fa fa-clock-o"></i>{{ $post->created_at->format('M d, Y') }}</li>
                                        </ul>
                                    </div>
                                    <h6 class="title"><a href="{{ route('article.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a></h6>
                                    <p>{{ Str::limit($post->excerpt, 80) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
