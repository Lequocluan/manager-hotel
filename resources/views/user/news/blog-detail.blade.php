@extends('user.layout_user.main')
@section('content')


    <!-- Blog Details Hero Section Begin -->
<section class="blog-details-hero set-bg" data-setbg="{{ $news->image }}">
    <div class="overlay"></div> <!-- Thêm lớp phủ -->
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="bd-hero-text text-white">
                    <span>{{ $news->newsCategories->name ?? '' }}</span>
                    <h2>{{ $news->title }}</h2>
                    <ul>
                        <li class="b-time"><i class="icon_clock_alt"></i> {{ $news->created_at->format('d M, Y') }}</li>
                        <li><i class="icon_profile"></i> {{ $news->poster->name ?? 'admin' }}</li>
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
                                <span>Thể loại khác:</span>
                                @foreach ($allCategories as $cat)
                                <a href="{{ route('news.category', ['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                            @endforeach

                            </div>
                            @php
                                use Illuminate\Support\Str;
                                $shareUrl = urlencode(url()->current());
                                $shareTitle = urlencode($news->name);
                            @endphp

                            @section('meta')
                                <meta property="og:title" content="{{ $news->name }}" />
                                <meta property="og:description" content="{{ Str::limit(strip_tags($news->description), 150) }}" />
                                <meta property="og:image" content="{{ asset('news/' . $news->image) }}" />
                                <meta property="og:url" content="{{ url()->current() }}" />
                                <meta property="og:type" content="article" />
                            @endsection


                            <div class="social-share">
                                <span>Chia sẻ:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" title="Share on Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" title="Share on Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
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

@section('css')
<style>
    .blog-details-hero {
    position: relative;
    background-size: cover;
    background-position: center;
    color: #fff;
}

.blog-details-hero .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(236, 219, 202, 0.6), rgba(0,0,0, 0.6)); /* #dfa974 to đen */
    z-index: 1;
}

.bd-hero-text {
    position: relative;
    z-index: 2;
}

</style>
@endsection