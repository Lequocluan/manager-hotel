@extends('user.layout_user.main')
@section('content')


    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Tin tức</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Trang tin tức</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section blog-page spad">
        <div class="container">
            <div class="row">
                @if($news->count())
                    @foreach ($news as $blog)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-item set-bg" data-setbg="{{ asset($blog->image) }}">
                                <div class="bi-text">
                                    <span class="b-tag">{{ $blog->newsCategories->name }}</span>
                                    <h4>
                                        <a href="{{ route('news.blog-detail', ['slugCategory' => $blog->newsCategories->slug, 'slugBlog' => $blog->slug]) }}">
                                            <div class="text-truncate">{{ $blog->title }}</div>
                                        </a>
                                    </h4>
                                    <div class="b-time"><i class="icon_clock_alt"></i> {{ $blog->created_at->format('d M, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-12">
                        <div class="load-more">
                            {{ $news->links() }}
                        </div>
                    </div>
                @else
                    <div class="col-12 text-center py-5">
                        <h4>Chưa có tin tức nào thuộc thể loại "{{ $category->name }}"</h4>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

@endsection