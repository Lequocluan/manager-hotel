@extends('user.layout_user.main')
@section('content')


    <!-- Blog Details Hero Section Begin -->
    <section class="blog-details-hero set-bg" data-setbg="{{ $news ->image }}"><div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="bd-hero-text">
                    <span>{{ $news->newsCategories->name ?? '' }}</span>
                    <h2>{{ $news->title }}</h2>
                    <ul>
                        <li class="b-time text-black"><i class="icon_clock_alt"></i> {{ $news->created_at->format('d M, Y') }}</li>
                        <li class="text-black"><i class="icon_profile"></i> {{ $news->poster->name ?? 'admin' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="blog-details-text">
                        <div class="bd-quote">
                            <p>{!! $news->content !!}</p>
                        </div>

                        <div class="tag-share">
                            <div class="tags">
                                <span>Tags:</span>
                                @foreach ($allCategories as $cat)
                                <a href="{{ route('news.category', ['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                            @endforeach

                            </div>
                            <div class="social-share">
                                <span>Share:</span>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-tripadvisor"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Recommend Blog Section Begin -->
    <section class="recommend-blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Recommended</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($recommendedNews as $new)
                    <div class="col-md-4">
                        <div class="blog-item set-bg" data-setbg="{{ asset($new->image) }}">
                            <div class="bi-text">
                                <span class="b-tag">{{ $new->newsCategories->name ?? '' }}</span>
                                <h4 class="text-truncate text-white">
                                    <a href="{{ route('news.blog-detail', ['slugCategory' => $new->newsCategories->slug, 'slugBlog' => $new->slug]) }}">
                                        {{ $new->title }}
                                    </a>
                                </h4>
                                <div class="b-time"><i class="icon_clock_alt"></i> {{ $new->created_at->format('d M, Y') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <!-- Recommend Blog Section End -->

@endsection