@extends('user.layout_user.main')

@section('content')


    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Havana Hotel</h1>
                        <p style="font-size: 20px">Khách sạn Havana tự hào là điểm dừng chân lý tưởng cho du khách trong và ngoài nước khi đến với thành phố Nha Trang.</p>
                        <a href="{{ route('about-us') }}" class="primary-btn">Khám phá ngay</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Bắt đầu đặt phòng</h3>
                        <form id="booking-form" action="{{ route('booking.step1') }}" method="POST">
                            @csrf
                            <div class="check-date">
                                <label for="date-in">Ngày đến:</label>
                                <input type="text" class="date-input"id="date-in_"  readonly>
                                <input type="hidden" id="date-in" name="checkin">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Ngày đi:</label>
                                <input type="text" class="date-input" id="date-out_" readonly>
                                <input type="hidden" id="date-out" name="checkout">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label for="adults">Người lớn:</label>
                                <select id="adults" name="adults" onchange="redirectIfOther(this)">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} người</option>
                                    @endfor
                                    <option value="other">Chọn số người</option>
                                </select>
                            </div>

                            <div class="select-option">
                                <label for="children">Trẻ em:</label>
                                <select id="children" name="children" onchange="redirectIfOther(this)">
                                    @for ($i = 0; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} trẻ em</option>
                                    @endfor
                                    <option value="other">Chọn số người</option>
                                </select>
                            </div>

                            <button type="submit">Đặt phòng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="/user_asset/img/hero/hero-11.jpg"></div>
            <div class="hs-item set-bg" data-setbg="/user_asset/img/hero/hero-12.jpg"></div>
            <div class="hs-item set-bg" data-setbg="/user_asset/img/hero/hero-13.jpg"></div>
        </div>
    </section>
    
    <section class="aboutus-section spad">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <div class="about-text">
                        <div class="section-title">
                            <span>Về chúng tôi</span>
                            <h2>Havana Hotel khách sạn 5 sao giữa trung tâm thành phố.</h2>
                        </div>
                        <p class="f-para">Khách sạn Havana Nha Trang  cung cấp 1060 phòng lưu trú hướng biển, cùng hệ thống trang thiết bị, tiện ích hiện đại theo tiêu chuẩn 5 sao quốc tế. Là sự kết hợp khéo léo giữa kiến trúc nội thất theo phong cách châu Âu trên nền những vật liệu tự nhiên mang tính thẩm mỹ cao, làm toát lên vẻ sang trọng, để lại cho bạn một ấn tượng khó phai.</p>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div style="max-width: 100%;">
                        <img src="{{ asset('/user_asset/img/room/room-1.jpg') }}" alt="img-about-us" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Services Section Start -->
<section class="services-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Dịch vụ của chúng tôi</span>
                    <h2>Khám phá tiện ích tại Havana</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- 1. Nhà hàng cao cấp -->
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-033-dinner"></i>
                    <h4>Nhà hàng cao cấp</h4>
                    <p>Thưởng thức ẩm thực phong phú từ Á đến Âu trong không gian sang trọng, hiện đại ngay tại khách sạn.</p>
                </div>
            </div>
            <!-- 2. Bar & Lounge -->
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-012-cocktail"></i>
                    <h4>Bar & Lounge</h4>
                    <p>Không gian thư giãn với các loại cocktail đặc sắc, rượu vang cao cấp và âm nhạc nhẹ nhàng.</p>
                </div>
            </div>
            <!-- 3. Hồ bơi ngoài trời -->
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-027-relax"></i>
                    <h4>Hồ bơi</h4>
                    <p>Hồ bơi ngoài trời với tầm nhìn ra biển, lý tưởng để thư giãn và tận hưởng ánh nắng Nha Trang.</p>
                </div>
            </div>
            <!-- 4. Spa & Massage -->
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-026-bed"></i>
                    <h4>Spa & Massage</h4>
                    <p>Liệu trình chăm sóc cơ thể chuyên nghiệp giúp quý khách phục hồi năng lượng và cân bằng tinh thần.</p>
                </div>
            </div>
            <!-- 5. Giặt ủi -->
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-024-towel"></i>
                    <h4>Giặt ủi</h4>
                    <p>Dịch vụ giặt ủi nhanh chóng, sạch sẽ, đảm bảo trang phục luôn như mới trong suốt kỳ nghỉ.</p>
                </div>
            </div>
            <!-- 6. Đưa đón sân bay -->
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-044-clock-1"></i>
                    <h4>Đưa đón sân bay</h4>
                    <p>Xe đưa đón hiện đại, tài xế thân thiện, phục vụ quý khách đến/đi sân bay một cách tiện lợi.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->


    
    <section class="hp-room-section">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    @foreach ($roomTypes as $roomType)
                        <div class="col-lg-3 col-sm-6">
                            <div class="hp-room-item set-bg" data-setbg="{{ $roomType->image?? '/user_asset/img/room/room-1.jpg' }}">
                                <div class="hr-text">
                                    <h3>{{ $roomType->name }}</h3>
                                    <h2>{{ number_format($roomType->price) }}VND<span> / đêm</span></h2>
                                    <p>{{ $roomType->overview }}</p>
                                    <a href="{{ route('roomtype.detail', ['slug' => $roomType->slug]) }}" class="primary-btn">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <section class="testimonial-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Khách hàng nói gì?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="testimonial-slider owl-carousel">
                        <div class="ts-item">
                            <p>Chỗ nghỉ rộng rãi, tiện nghi đầy đủ, toạ lạc ngay trung tâm thành phố, thuận tiện đi bộ tới mọi nơi.. nhân viên nhiệt tình, thân thiện.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img width="30px" height="30px" src="/uploads/avatars/user.png" alt="">
                        </div>
                        <div class="ts-item">
                            <p>Chỗ nghỉ rộng rãi, tiện nghi đầy đủ, toạ lạc ngay trung tâm phố cổ Colmar, thuận tiện đi bộ tới mọi nơi.. nhân viên nhiệt tình, thân thiện.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img width="30px" height="30px" src="/uploads/avatars/user.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Tin tức và sự kiện của chúng tôi</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($news as $blog)
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="{{ $blog->image }}">
                        <div class="bi-text">
                            <span class="b-tag">{{ $blog ->newsCategories->name }}</span>
                            <div class="text-white">
                                <h4 class=" text-truncate"><a href="{{ route('news.blog-detail', ['slugCategory' => $blog->newsCategories->slug, 'slugBlog' => $blog->slug]) }}">{{ $blog -> title }}</a></h4>
                            </div>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
@section('js')
<script>
    $(function () {
    $(".date-input").datepicker({
        minDate: 0,
        dateFormat: 'dd MM, yy'
    });

    $('#booking-form').on('submit', function (e) {
        const parseDate = (str) => {
            const date = $.datepicker.parseDate('dd MM, yy', str);
            return $.datepicker.formatDate('yy-mm-dd', date);
        }

        const checkinDisplay = $('#date-in_').val();
        const checkoutDisplay = $('#date-out_').val();

        if (!checkinDisplay || !checkoutDisplay) {
            alert('Vui lòng chọn ngày nhận và trả phòng.');
            e.preventDefault();
            return;
        }

        const checkinDate = $.datepicker.parseDate('dd MM, yy', checkinDisplay);
        const checkoutDate = $.datepicker.parseDate('dd MM, yy', checkoutDisplay);

        if (checkinDate.getTime() === checkoutDate.getTime()) {
            alert('Ngày nhận phòng và trả phòng phải khác nhau.');
            e.preventDefault();
            return;
        }

        if (checkoutDate < checkinDate) {
            alert('Ngày trả phòng phải sau ngày nhận phòng.');
            e.preventDefault();
            return;
        }

        $('#date-in').val(parseDate(checkinDisplay));
        $('#date-out').val(parseDate(checkoutDisplay));
    });
});

    function redirectIfOther(selectElement) {
        if (selectElement.value === 'other') {
            window.location.href = "{{ route('booking.start') }}";
        }
    }
</script>

@endsection