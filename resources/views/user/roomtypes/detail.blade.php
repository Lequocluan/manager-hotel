@extends('user.layout_user.main')

@section('content')

<div class="room-header" style="position: relative;">
    <img src="{{ asset($roomType->image) }}" class="img-fluid w-100" style="height: 400px; object-fit: cover;" alt="Ảnh loại phòng">
    
    <div class="room-header-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4);">
        <div class="container h-100 d-flex flex-column justify-content-center align-item-center text-white text-center">
            <ul class="breadcrumb d-flex justify-content-center gap-2 text-center" style="background: none; list-style: none; padding: 0;">
                <li><a href="{{ route('home') }}" class="text-white text-decoration-underline">Trang chủ</a></li>
                <li>/</li>
                <li><a href="{{ route('roomtypes.list') }}">Phòng</a></li>
                <li>/</li>
                <li class="text-upp">{{ $roomType->name }}</li>
            </ul>
            <h2 class="mt-2">{{ $roomType->name }}</h2>
        </div>
    </div>
</div>
<section class="room-details-section spad container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="rd-pic">
                @if($roomType->images->count() > 0)
                <div id="roomTypeCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($roomType->images as $key => $image)
                            <button type="button" data-bs-target="#roomTypeCarousel" data-bs-slide-to="{{ $key }}"
                                    class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach($roomType->images as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <img src="{{ asset($image->image_path) }}" class="d-block w-100 img-fluid rounded"
                                    style="height: 400px; object-fit: cover;" alt="Ảnh {{ $key + 1 }}">
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#roomTypeCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomTypeCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                @else
                    <img src="{{ asset($roomType->image) }}" class="img-fluid rounded" alt="Ảnh phòng">
                @endif
            </div>
            <div class="rd-info mt-4">
                <h4>Thông tin chi tiết</h4>
                <ul class="list-unstyled">
                    <li><strong>Giá:</strong> {{ number_format($roomType->price) }} VNĐ / đêm</li>
                    <li><strong>Diện tích:</strong> {{ $roomType->size }} m<sup>2</sup></li>
                    <li><strong>Loại giường:</strong> {{ $roomType->bed_type }}</li>
                    <li><strong>Số người tối đa:</strong> {{ $roomType->max_adults }} người lớn, {{ $roomType->max_children }} trẻ em</li>
                </ul>
            </div>
        </div>

        <div class="col-md-6 d-flex flex-column justify-content-center align-items-between ">
            <h4>Mô tả</h4>
            <p>{!! $roomType->description !!}</p>
        </div>
    </div>
</section>


@php
    $roomChunks = $ortherRoomTypes->chunk(2); 
@endphp

<section id="otherRoomCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        @foreach ($roomChunks as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                <div class="row justify-content-center">
                    @foreach ($chunk as $roomType)
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('roomtype.detail', ['slug' => $roomType->slug]) }}" class="text-decoration-none">
                                <div class="room-hover-box position-relative rounded shadow-sm overflow-hidden">
                                    <img src="{{ asset($roomType->image) }}" class="w-100 room-image" alt="{{ $roomType->name }}">
                                    <div class="room-info-overlay d-flex flex-column justify-content-center align-items-center text-white text-center p-3">
                                        <h5 class="mb-2">{{ $roomType->name }}</h5>
                                        <h6 class="text-danger mb-2">{{ number_format($roomType->price) }} VND <span class="text-muted">/ đêm</span></h6>
                                        <p class="small">{{ $roomType->overview }}</p>
                                        <p class="mb-0">
                                            <strong>Diện tích:</strong> {{ $roomType->size }} m<sup>2</sup>
                                        </p>
                                        <p class="mb-0">
                                            <strong>Số người tối đa:</strong>{{ $roomType->max_adults }} người lớn, {{ $roomType->max_children }} trẻ em
                                        </p>                      
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>


    <button class="carousel-control-prev" type="button" data-bs-target="#otherRoomCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#otherRoomCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>


    <div class="carousel-indicators mt-3">
        @foreach ($roomChunks as $chunkIndex => $chunk)
            <button type="button" data-bs-target="#otherRoomCarousel" data-bs-slide-to="{{ $chunkIndex }}"
                class="{{ $chunkIndex === 0 ? 'active' : '' }}"
                aria-current="{{ $chunkIndex === 0 ? 'true' : 'false' }}"
                aria-label="Slide {{ $chunkIndex + 1 }}"></button>
        @endforeach
    </div>
</section>



@endsection

@section('css')
<style>
    .room-hover-box {
        position: relative;
        overflow: hidden;
        height: 500px;
    }

    .room-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .room-info-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 10;
    }

    .room-hover-box:hover .room-info-overlay {
        opacity: 1;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
        opacity: 0.8;
        z-index: 11;
    }

    .carousel-indicators {
        justify-content: center;
        gap: 8px;
    }

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #bbb;
        border: none;
        opacity: 0.6;
    }

    .carousel-indicators button.active,
    .carousel-indicators button:hover {
        background-color: #333;
        opacity: 1;
    }
</style>
@endsection



@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var carousel = document.getElementById('otherRoomCarousel');
    if (carousel) {
        var bsCarousel = new bootstrap.Carousel(carousel, {
            interval: 3000,
            ride: 'carousel',
            pause: 'hover'
        });
    }
</script>
@endsection
