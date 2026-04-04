                <div class="col-lg-3 col-md-6">
                    <div class="section-title">
                        <h6 class="title">What’s new</h6>
                    </div>
                    <div class="post-slider owl-carousel">
                        @if(isset($gridArticles) && $gridArticles->count() > 0)
                             @foreach($gridArticles as $post)
                            <div class="item">
                                <div class="single-post-wrap">
                                    <div class="thumb">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img">
                                        @else
                                            <img src="{{ asset('nextpage-lite/assets/img/post/8.png') }}" alt="img">
                                        @endif
                                    </div>
                                    <div class="details">
                                        <div class="post-meta-single mb-4 pt-1">
                                            <ul>
                                                @if($post->category)
                                                <li><a class="tag-base tag-blue" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                                                @endif
                                                <li><i class="fa fa-clock-o"></i>{{ $post->published_at->translatedFormat('d M Y') }}</li>
                                            </ul>
                                        </div>
                                        <h6 class="title"><a href="{{ route('article.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a></h6>
                                        <p>{{ Str::limit($post->excerpt, 80) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <!-- Fallback What's New -->
                            <div class="item">
                                <div class="single-post-wrap">
                                    <div class="thumb">
                                        <img src="{{ asset('nextpage-lite/assets/img/post/8.png') }}" alt="img">
                                    </div>
                                    <div class="details">
                                        <div class="post-meta-single mb-4 pt-1">
                                            <ul>
                                                <li><a class="tag-base tag-blue" href="#">Tech</a></li>
                                                <li><i class="fa fa-clock-o"></i>{{ date('M d, Y') }}</li>
                                            </ul>
                                        </div>
                                        <h6 class="title"><a href="#">Sample Article for What's New</a></h6>
                                        <p>This is a sample excerpt text to show how the layout looks.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
