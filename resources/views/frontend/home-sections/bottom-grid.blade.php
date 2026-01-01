    <div class="bg-sky pd-top-80 pd-bottom-50" id="grid">
<div class="bg-sky pd-top-80 pd-bottom-50" id="grid">
        <div class="container">
            <div class="row">
                @if(isset($latestArticles) && $latestArticles->count() > 0)
                    @foreach($latestArticles->shuffle()->take(4) as $post)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-post-wrap style-overlay-bg">
                            <div class="thumb">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img" style="height: 220px; width: 100%; object-fit: cover;">
                                @else
                                    <img src="{{ asset('nextpage-lite/assets/img/post/15.png') }}" alt="img" style="height: 220px; width: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div class="details" style="min-height: 160px;">
                                <div class="post-meta-single mb-3">
                                    <ul>
                                        @if($post->category)
                                        <li><a class="tag-base tag-purple" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                                        @endif
                                        <li><p><i class="fa fa-clock-o"></i>{{ $post->created_at->format('M d, Y') }}</p></li>
                                    </ul>
                                </div>
                                <h6 class="title"><a href="{{ route('article.show', $post->slug) }}">{{ Str::limit($post->title, 45) }}</a></h6>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback Bottom Grid -->
                    @for($i=15; $i<=18; $i++)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-post-wrap style-overlay">
                            <div class="thumb">
                                <img src="{{ asset('nextpage-lite/assets/img/post/'.$i.'.png') }}" alt="img">
                                <a class="tag-base tag-purple" href="#">Tech</a>
                            </div>
                            <div class="details">
                                <div class="post-meta-single">
                                    <p><i class="fa fa-clock-o"></i>{{ date('M d, Y') }}</p>
                                </div>
                                <h6 class="title"><a href="#">Sample Grid Article {{ $i }}</a></h6>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>  
    </div>
