    <!-- banner area start -->
    <div class="banner-area banner-inner-1 bg-black" id="banner">
        <div class="banner-inner pt-5">
            <div class="container">
                <div class="row">
                    <!-- Main Banner Article -->
                    @if(isset($bannerArticles) && $bannerArticles->count() > 0)
                    @php $mainBanner = $bannerArticles->first(); @endphp
                    <div class="col-lg-6">
                        <div class="thumb after-left-top">
                            @if($mainBanner->featured_image)
                                <img src="{{ asset('storage/' . $mainBanner->featured_image) }}" alt="{{ $mainBanner->title }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-dark" style="height: 350px; width: 100%;">
                                    <i class="fa fa-camera text-white-50 fa-4x"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-center">
                        <div class="banner-details mt-4 mt-lg-0">
                            <div class="post-meta-single">
                                <ul>
                                    @if($mainBanner->category)
                                    <li><a class="tag-base tag-blue" href="{{ route('category.show', $mainBanner->category->slug) }}">{{ $mainBanner->category->name }}</a></li>
                                    @endif
                                    <li class="date"><i class="fa fa-clock-o"></i>{{ $mainBanner->created_at->format('M d, Y') }}</li>
                                </ul>
                            </div>
                            <h2>{{ Str::limit($mainBanner->title, 60) }}</h2>
                            <p>{{ Str::limit($mainBanner->excerpt ?? strip_tags($mainBanner->content), 100) }}</p>
                            <!-- Note: Need to link to article detail route -->
                            <a class="btn btn-blue" href="{{ route('article.show', $mainBanner->slug) }}">Read More</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <!-- Side Banner Articles -->
                @if(isset($bannerArticles))
                @foreach($bannerArticles->skip(1) as $bannerItem)
                <div class="col-lg-3 col-sm-6">
                    <div class="single-post-wrap style-white">
                        <div class="thumb">
                            @if($bannerItem->featured_image)
                                <img src="{{ asset('storage/' . $bannerItem->featured_image) }}" alt="{{ $bannerItem->title }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-secondary" style="height: 150px; width: 100%;">
                                    <i class="fa fa-picture-o text-white-50 fa-2x"></i>
                                </div>
                            @endif
                            @if($bannerItem->category)
                                <a class="tag-base tag-blue" href="{{ route('category.show', $bannerItem->category->slug) }}">{{ $bannerItem->category->name }}</a>
                            @endif
                        </div>
                        <div class="details">
                            <h6 class="title"><a href="{{ route('article.show', $bannerItem->slug) }}">{{ Str::limit($bannerItem->title, 40) }}</a></h6>
                            <div class="post-meta-single mt-3">
                                <ul>
                                    <li><i class="fa fa-clock-o"></i>{{ $bannerItem->created_at->format('M d, Y') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>  
    </div>
    <!-- banner area end -->
