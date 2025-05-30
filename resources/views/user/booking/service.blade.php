@extends('user.layout_user.main')

@section('content')
<style>
    /* Card dịch vụ */
    .service-card {
        cursor: pointer;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        padding: 1.25rem;
        background-color: #e3f2fd; /* light blue */
        transition: background-color 0.3s ease, border-color 0.3s ease;
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    /* Khi hover */
    .service-card:hover {
        background-color: #bbdefb;
        border-color: #1976d2;
    }
    /* Checkbox lớn */
    .service-checkbox {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
    }
    /* Label chứa text */
    .service-label {
        flex-grow: 1;
        user-select: none;
    }
    /* Khi checkbox được chọn: đổi background và viền card */
    .service-card input[type="checkbox"]:checked + .service-label {
        font-weight: 600;
        color: #0d47a1;
    }
    .service-card input[type="checkbox"]:checked {
        accent-color: #0d6efd;
    }
    /* Ẩn checkbox mặc định, dùng custom */
    .service-card input[type="checkbox"] {
        cursor: pointer;
    }
</style>

<div class="container py-5">
    <h3 class="mb-4 text-primary">Chọn dịch vụ bổ sung</h3>
    <form action="{{ route('booking.step3') }}" method="POST">
        @csrf
        <div class="row g-3">
            @foreach($services as $service)
            <div class="col-12 col-md-4">
                <label class="service-card">
                    <input 
                        type="checkbox" 
                        name="services[]" 
                        value="{{ $service->id }}" 
                        class="service-checkbox"
                    >
                    <div class="service-label">
                        <div class="fw-bold">{{ $service->name }}</div>
                        <div class="text-success">{{ number_format($service->price, 0, ',', '.') }} VNĐ</div>
                        @if(!empty($service->description))
                            <small class="text-muted">{{ $service->description }}</small>
                        @endif
                    </div>
                </label>
            </div>
            @endforeach
        </div>
            
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('booking.selectRoom') }}" class="btn btn-lg btn-secondary px-5 shadow rounded-pill fw-bold">
                <i class="fa fa-arrow-left me-2 mr-2"></i>Quay lại
            </a>
            <button class="btn btn-lg btn-primary px-5 shadow rounded-pill fw-bold" type="submit">
                Tiếp tục<i class="fa fa-arrow-right me-2 ml-2"></i>
            </button>
        </div>

    </form>
</div>
@endsection
