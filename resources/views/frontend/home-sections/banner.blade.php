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
                                    <img src="{{ asset('nextpage-lite/assets/img/banner/1.png') }}" alt="img">
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 align-self-center">
                            <div class="banner-details mt-4 mt-lg-0">
                                <div class="post-meta-single">
                                    <ul>
                                        @if($mainBanner->category)
                                        <li><a class="tag-base tag-blue" href="#">{{ $mainBanner->category->name }}</a></li>
                                        @endif
                                        <li class="date"><i class="fa fa-clock-o"></i>{{ $mainBanner->created_at->format('M d, Y') }}</li>
                                    </ul>
                                </div>
                                <h2>{{ Str::limit($mainBanner->title, 60) }}</h2>
                                <p>{{ Str::limit($mainBanner->excerpt ?? strip_tags($mainBanner->content), 100) }}</p>
                                <a class="btn btn-blue" href="{{ route('page.show', $mainBanner->slug) }}">Read More</a>
                            </div>
                        </div>
                    @else
                        <!-- FALLBACK CONTENT (If DB is empty) -->
                        <div class="col-lg-6">
                            <div class="thumb after-left-top">
                                <img src="{{ asset('nextpage-lite/assets/img/banner/1.png') }}" alt="img">
                            </div>
                        </div>
                        <div class="col-lg-6 align-self-center">
                            <div class="banner-details mt-4 mt-lg-0">
                                <div class="post-meta-single">
                                    <ul>
                                        <li><a class="tag-base tag-blue" href="#">Tech (Sample)</a></li>
                                        <li class="date"><i class="fa fa-clock-o"></i>{{ date('M d, Y') }}</li>
                                    </ul>
                                </div>
                                <h2>Welcome to NextPage - Add your first article in Admin Panel</h2>
                                <p>This is a sample text. Once you add content in the admin panel, it will appear here automatically.</p>
                                <a class="btn btn-blue" href="#">Read More</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <!-- Side Banner Articles -->
                @if(isset($bannerArticles) && $bannerArticles->count() > 1)
                    @foreach($bannerArticles->skip(1) as $bannerItem)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-post-wrap style-white">
                            <div class="thumb">
                                @if($bannerItem->featured_image)
                                    <img src="{{ asset('storage/' . $bannerItem->featured_image) }}" alt="{{ $bannerItem->title }}" style="height: 180px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('nextpage-lite/assets/img/post/1.png') }}" alt="img">
                                @endif
                                @if($bannerItem->category)
                                    <a class="tag-base tag-blue" href="#">{{ $bannerItem->category->name }}</a>
                                @endif
                            </div>
                            <div class="details">
                                <h6 class="title"><a href="#">{{ Str::limit($bannerItem->title, 40) }}</a></h6>
                                <div class="post-meta-single mt-3">
                                    <ul>
                                        <li><i class="fa fa-clock-o"></i>{{ $bannerItem->created_at->format('M d, Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- FALLBACK SIDE BANNERS -->
                    @for($i=1; $i<=4; $i++)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-post-wrap style-white">
                            <div class="thumb">
                                <img src="{{ asset('nextpage-lite/assets/img/post/'.$i.'.png') }}" alt="img">
                                <a class="tag-base tag-blue" href="#">Tech</a>
                            </div>
                            <div class="details">
                                <h6 class="title"><a href="#">Sample Article Title #{{ $i }}</a></h6>
                                <div class="post-meta-single mt-3">
                                    <ul>
                                        <li><i class="fa fa-clock-o"></i>{{ date('M d, Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>  
    </div>
    <!-- banner area end -->
