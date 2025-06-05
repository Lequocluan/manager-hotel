@extends('user.layout_user.main')
@section('content')

    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Về chúng tôi</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <section class="aboutus-page-section spad">
        <div class="container">
            <div class="about-page-text">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ap-title">
                            <h2>Chào mừng bạn đến với khách sạn Havana.</h2>
                            <p>Khách sạn 5 sao với đầy đủ tiện nghi, dịch vụ, giải trí sang trọng nằm ở trung tâm thành phố nha trang.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <ul class="ap-services">
                            <li><i class="icon_check"></i> Miễn phí 3 món giặt ủi mỗi ngày.</li>
                            <li><i class="icon_check"></i> Wifi tốc độ cao miễn phí.</li>
                            <li><i class="icon_check"></i> Nơi đỗ xe rộng rãi.</li>
                            <li><i class="icon_check"></i> Wifi miễn phí.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="about-page-services">
                <div class="row">
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="/user_asset/img/about/about-p1.jpg">
                            <div class="api-text">
                                <h3>Dịch vụ nhà hàng</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="/user_asset/img/about/about-p2.jpg">
                            <div class="api-text">
                                <h3>Spa và thư giãn</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="/user_asset/img/about/about-p3.jpg">
                            <div class="api-text">
                                <h3>Sự kiện và ăn mừng</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="video-section set-bg" data-setbg="/user_asset/img/video-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <h2>Khám phá khách sạn & dịch vụ của chúng tôi.</h2>
                        <p>View nhìn trên cao về khách sạn Havana của chúng tôi được quay bằng flycam.</p>
                        <a href="https://www.youtube.com/watch?v=n0fb901wbwk" class="play-btn video-popup"><img
                                src="/user_asset/img/play.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="gallery-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Thư viện ảnh</span>
                        <h2>Khám phá không gian tại Havana</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="gallery-item set-bg" data-setbg="/user_asset/img/gallery/gallery-1.jpg">
                        <div class="gi-text">
                            <h3>Phòng nghỉ cao cấp</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="/user_asset/img/gallery/gallery-3.jpg">
                                <div class="gi-text">
                                    <h3>Nhà hàng sang trọng</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="/user_asset/img/gallery/gallery-4.jpg">
                                <div class="gi-text">
                                    <h3>Tầm nhìn hướng biển</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gallery-item large-item set-bg" data-setbg="/user_asset/img/gallery/gallery-2.jpg">
                        <div class="gi-text">
                            <h3>Hồ bơi ngoài trời</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection