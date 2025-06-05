@extends('user.layout_user.main')

@section('content')
<div class="container py-5">
    <h3 class="mb-4 text-center fw-bold text-primary">Chọn loại phòng phù hợp</h3>


    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li class="fw-semibold">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
    @if (session('suggestion'))
        <div class="alert alert-info shadow-sm rounded-3">
            <strong>Gợi ý chia phòng:</strong> {{ session('suggestion') }}
        </div>
    @endif

    <form action="{{ route('booking.step2') }}" method="POST" class="bg-white p-4 rounded-4 shadow-sm">
        @csrf
        <div class="row g-4">
            @foreach($roomTypes as $roomType)
                @php
                    $firstRoom = $roomType->rooms->first();
                    $oldRoomType = old('room_types.' . $roomType->id, []);
                    $selected = isset($oldRoomType['selected']);
                    $quantity = $oldRoomType['quantity'] ?? 1;
                @endphp
                @if($firstRoom)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 room-card-hover position-relative">
                        <div class="position-relative">
                            <img height="300px" src="{{ asset($roomType->image) }}" class="card-img-top rounded-top-4" alt="">
                            <span class="badge bg-primary price-badge shadow">
                                {{ number_format($roomType->price) }} VNĐ/đêm
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">{{ $roomType->name }}</h5>
                            <p class="card-text text-muted small mb-2">{{ $roomType->overview }}</p>
                            <ul class="list-unstyled mb-3">
                                <li><i class="fa fa-users text-primary me-1"></i> Tối đa: {{ $roomType->max_adults }} người lớn, {{ $roomType->max_children }} trẻ em</li>
                                <li><i class="fa fa-bed text-primary me-1"></i> {{ $roomType->bed_type }}</li>
                                <li><i class="fa fa-expand text-primary me-1"></i> {{ $roomType->size }} m<sup>2</sup></li>
                            </ul>
                            <div class="d-flex align-items-center mt-auto">
                                <div class="form-check me-2">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="room_types[{{ $roomType->id }}][selected]"
                                        value="1"
                                        id="room_type_{{ $roomType->id }}"
                                        {{ $selected ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="room_type_{{ $roomType->id }}">Chọn</label>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <label for="quantity_{{ $roomType->id }}" class="form-label mb-0 small text-muted">Số lượng:</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm d-inline-block w-auto ms-1"
                                        name="room_types[{{ $roomType->id }}][quantity]"
                                        min="1"
                                        value="{{ $quantity }}"
                                        style="width: 60px;"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('booking.start') }}" class="btn btn-lg btn-secondary px-5 shadow rounded-pill fw-bold">
                <i class="fa fa-arrow-left me-2 mr-2"></i>Quay lại
            </a>
            <button class="btn btn-lg btn-primary px-5 shadow rounded-pill fw-bold" type="submit">
                Tiếp tục<i class="fa fa-arrow-right me-2 ml-2"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('css')
<style>
    .room-card-hover {
        transition: box-shadow 0.2s, transform 0.2s;
        position: relative;
    }
    .room-card-hover:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 1.5px 6px rgba(0,0,0,0.08);
        transform: translateY(-4px) scale(1.02);
        border-color: #0d6efd;
    }
    .card-title {
        font-size: 1.2rem;
    }
    .badge.bg-primary.price-badge {
        font-size: 1rem;
        border-radius: 1rem;
        position: absolute;
        top: 12px;
        left: 12px;
        right: auto;
        z-index: 2;
        padding: 0.5em 1.2em;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
    }
</style>
@endsection
