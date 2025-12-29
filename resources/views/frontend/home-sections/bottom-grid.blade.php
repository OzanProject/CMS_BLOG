    <div class="bg-sky pd-top-80 pd-bottom-50" id="grid">
        <div class="container">
            <div class="row">
                @if(isset($gridArticles))
                @foreach($gridArticles as $post)
                <div class="col-lg-3 col-sm-6">
                    <div class="single-post-wrap style-overlay">
                        <div class="thumb" style="height: 200px; overflow: hidden; border-radius: 5px;">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="img" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-secondary" style="height: 100%; width: 100%;">
                                    <i class="fa fa-newspaper-o text-white-50 fa-2x"></i>
                                </div>
                            @endif
                            @if($post->category)
                            <a class="tag-base tag-purple" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a>
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
                @endif
            </div>
        </div>  
    </div>
