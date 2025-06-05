@extends('user.layout_user.main')

@section('title', 'Xác nhận & Thanh toán')

@section('content')
<div class="container py-5">
    <h3 class="mb-4 text-center text-primary"><i class="fa fa-bell"></i> Xác nhận & Thanh toán</h3>

    <form action="{{ route('booking.confirm') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light fw-bold">
                        <i class="fa fa-user me-2"></i> Thông tin khách hàng
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="0123456789" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Yêu cầu đặc biệt (nếu có)"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light fw-bold">
                        <i class="fa fa-book me-2"></i> Thông tin đặt phòng
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Ngày nhận phòng:</strong> {{ $step1['checkin'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Ngày trả phòng:</strong> {{ $step1['checkout'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Phòng đã chọn:</strong><br>
                                @foreach ($roomDetails as $index => $detail)
                                    <span style="color:#333; font-weight:bold; margin-right:6px;">&bull;</span>
                                    {{ $detail['roomType']->name }}
                                    @if ($detail['quantity'] > 1)
                                        x {{ $detail['quantity'] }}
                                    @endif
                                    <br>
                                @endforeach
                            </li>

                            <li class="list-group-item">
                                <strong>Dịch vụ đi kèm:</strong><br>
                                @forelse($serviceModels as $service)
                                    <span style="color:#333; font-weight:bold; margin-right:6px;">&bull;</span> {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} VNĐ)<br>
                                @empty
                                    Không có dịch vụ
                                @endforelse
                            </li>
                            <li class="list-group-item fw-bold">
                                <strong>Tổng tiền:</strong> 
                                <span class="text-success">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-light fw-bold">
                <i class="fa fa-credit-card me-2"></i> Phương thức thanh toán
            </div>
            <div class="row card-body">
                <div class="col-md-6 form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" id="pay_hotel" value="0" checked>
                    <label class="form-check-label" for="pay_hotel">
                        Thanh toán tại khách sạn
                    </label>
                </div>
                <div class="col-md-6 form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="online_payment" value="1">
                    <label class="form-check-label" for="online_payment">
                        Thanh toán online (VNPAY, Momo)
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('booking.selectServices') }}" class="btn btn-lg btn-secondary px-5 shadow rounded-pill fw-bold">
                <i class="fa fa-arrow-left me-2 mr-2"></i>Quay lại
            </a>
            <button class="btn btn-lg btn-success px-5 shadow rounded-pill fw-bold" type="submit">
                Đặt phòng<i class="fa fa-arrow-right me-2 ml-2"></i>
            </button>
        </div>
    </form>
</div>
@endsection
