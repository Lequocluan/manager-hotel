@php use Illuminate\Support\Facades\DB; @endphp
@extends('user.layout_user.main')

@section('content')
<div class="container-fluid">
    
<div class="row">
    <div class="col-md-8 py-5">
        <h2 class="mb-4 text-center">Đặt phòng khách sạn</h2>
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="room_type_id" class="form-label">Loại phòng <span class="text-danger">*</span></label>
                    <select name="room_type_id" class="tag-select form-control @error('room_type_id') is-invalid @enderror">
                        <option value="">-- Chọn loại phòng --</option>
                        @foreach ($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="check_in" class="form-label">Ngày nhận phòng <span class="text-danger">*</span></label>
                    <input type="date" name="check_in" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="check_out" class="form-label">Ngày trả phòng <span class="text-danger">*</span></label>
                    <input type="date" name="check_out" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label">Số lượng phòng <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary px-5" type="submit">Đặt phòng</button>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <div class="card">
            @php
                // Lấy loại phòng đầu tiên hoặc theo slug nếu có
                $roomType = request('slug')
                    ? $roomTypes->where('slug', request('slug'))->first()
                    : ($dataRommTypes[0] ?? $roomTypes[0] ?? null);
            @endphp
            @if($roomType)
                <div class="carousel-container" id="myCarousel">
                    <div class="carousel-slides">
                        @foreach ($roomType->images as $img)
                            <img height="300px" src="{{ asset($img->image_path) }}" class="carousel-image">
                        @endforeach
                        @if($roomType->images->isEmpty())
                            <img src="{{ asset($roomType->image) }}" class="carousel-image">
                        @endif
                    </div>
                    @if ($roomType->images->count() > 1)
                        <button class="carousel-btn prev" onclick="changeSlide(-1)">&#10094;</button>
                        <button class="carousel-btn next" onclick="changeSlide(1)">&#10095;</button>
                    @endif
                </div>
    
                <div class="card-body">
                    <h5 class="card-title">{{ $roomType->name }}</h5>
                    <p class="card-text mb-1"><strong>Giá:</strong> {{ number_format($roomType->price) }} VNĐ/đêm</p>
                    <p class="card-text mb-1"><strong>Mô tả:</strong> {{ $roomType->overview }}</p>
                    <p class="card-text"><strong>Chi tiết:</strong> {!! $roomType->description !!}</p>
                </div>
            @else
                <div class="card-body">
                    <p class="text-muted">Vui lòng chọn loại phòng để xem chi tiết.</p>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('admin_asset/css/custom/custom.css') }}">
    <style>
        .carousel-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 10px;
        }
        .carousel-slides {
            display: flex;
            transition: transform 0.4s ease-in-out;
        }
        .carousel-image {
            min-width: 100%;
            object-fit: cover;
        }
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.4);
            color: white;
            border: none;
            font-size: 24px;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }
        .carousel-btn.prev { left: 10px; }
        .carousel-btn.next { right: 10px; }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let currentIndex = 0;
    const carousel = document.querySelector('#myCarousel .carousel-slides');
    const slides = carousel.querySelectorAll('.carousel-image');

    function changeSlide(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = slides.length - 1;
        if (currentIndex >= slides.length) currentIndex = 0;
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    };

    $(document).ready(function() {
        $(".tag-select").select2({
            placeholder: "Chọn loại phòng",
            allowClear: true
        });
    });
</script>
@endsection