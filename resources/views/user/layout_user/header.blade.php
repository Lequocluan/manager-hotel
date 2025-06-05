<!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="canvas-open">
        <i class="icon_menu"></i>
    </div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="search-icon  search-switch">
            <i class="icon_search"></i>
            <a href="{{ route('booking.start') }}" class="bk-btn d-none" id="sticky-booking-btn">Đặt ngay</a>
        </div>
        <div class="header-configure-area">
            <a href="{{ route('booking.start') }}" class="bk-btn">Đặt ngay</a>
        </div>
        <nav class="mainmenu mobile-menu">
            <ul>
                <li class="active"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li>
                    <a href="{{route('roomtypes.list')}}">Loại phòng</a>
                </li>
                <li>
                    <a href="{{ route('news.category', ['slug' => $allCategories[0]->slug ?? 'news']) }}">Tin tức</a>
                    <ul class="dropdown">
                        @foreach($allCategories as $cat)
                            <li>
                                <a href="{{ route('news.category', ['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('about-us') }}">Về chúng tôi</a></li>
                <li><a href="{{ route('contact')}}">Liên hệ</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="top-social">
            <a target="_blank" href="https://www.facebook.com/havananhatranghotel"><i class="fa fa-facebook-f"></i></a>
            <a target="_blank" href="https://x.com/Havananhatrang"><i class="fa fa-twitter"></i></a>
            <a target="_blank" href="https://www.instagram.com/havananhatrang"><i class="fa fa-instagram"></i></a>
        </div>
        <ul class="top-widget">
            <li><i class="fa fa-phone"></i> (12) 345 67890</li>
            <li><i class="fa fa-envelope"></i>info@havanahotel.vn</li>
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->

<header class="header-section">
        <div class="top-nav" id="top-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                            <li><i class="fa fa-phone"></i> (12) 345 67890</li>
                            <li><i class="fa fa-envelope"></i>info@havanahotel.vn</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tn-right">
                            <div class="top-social">
                                <a target="_blank" href="https://www.facebook.com/havananhatranghotel"><i class="fa fa-facebook-f"></i></a>
                                <a target="_blank" href="https://x.com/Havananhatrang"><i class="fa fa-twitter"></i></a>
                                <a target="_blank" href="https://www.instagram.com/havananhatrang"><i class="fa fa-instagram"></i></a>
                            </div>
                            <a href="{{ route('booking.start') }}" class="bk-btn">Đặt ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item fixed-top shadow-sm bg-white" id="menu-bar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img width="50px"; height="50px" src="https://havanahotel.vn/storage/logo-mini.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="nav-menu">
                            <nav class="mainmenu">
                                <ul>
                                    <li class="active"><a href="{{ route('home') }}">Trang chủ</a></li>
                                    <li><a href="{{route('roomtypes.list')}}">Loại phòng</a></li>
                                    <li><a href="{{ route('about-us') }}">Về chúng tôi</a></li>
                                    <li>
                                        <a href="{{ route('news.category', ['slug' => $allCategories[0]->slug ?? 'news']) }}">Tin tức</a>
                                        <ul class="dropdown">
                                            @foreach($allCategories as $cat)
                                                <li>
                                                    <a href="{{ route('news.category', ['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('contact')}}">Liên hệ</a></li>
                                </ul>
                            </nav>
                            <div class="nav-right search-switch">
                                <i class="icon_search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>