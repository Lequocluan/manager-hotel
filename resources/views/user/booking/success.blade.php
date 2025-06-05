@extends('user.layout_user.main') 

@section('title', 'Đặt phòng thành công')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-success"> Đặt phòng thành công!</h1>
        <p class="lead">Cảm ơn bạn đã tin tưởng lựa chọn khách sạn của chúng tôi. Dưới đây là thông tin đặt phòng của bạn.</p>
    </div>

    @if($booking)
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-dark text-white fw-semibold text-center">
                        Mã đặt phòng: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                        <p><strong>Thời gian đặt:</strong> {{ $booking->created_at->format('H:i d/m/Y') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ tên:</strong> {{ $booking->name }}</p>
                                <p><strong>Số điện thoại:</strong> {{ $booking->phone }}</p>
                                <p><strong>Email:</strong> {{ $booking->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Ngày nhận phòng:</strong> {{ $booking->check_in_date->format('d/m/Y') }}</p>
                                <p><strong>Ngày trả phòng:</strong> {{ $booking->check_out_date->format('d/m/Y') }}</p>
                                <p ><strong>Số lượng khách:</strong> {{ session('adults') }} người lớn
                                    @if (session('children') > 0)
                                        , {{ session('children') }} trẻ em
                                    @endif
                                </p>
                            </div>
                        </div>
                                <p class="text-center"><strong>Ghi chú:</strong> {{ $booking->notes ?: 'Không có' }}</p>

                    </div>
                </div>

                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-primary text-white fw-semibold">
                        Thông tin phòng
                    </div>
                    <div class="card-body">
                        @foreach($booking->rooms as $bookingRoom)
                            <div class="mb-4">
                                <h5 class="fw-bold text-center">{{ $bookingRoom->roomType ->name }}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{ asset($bookingRoom->roomType ->image) }}" alt="{{ $bookingRoom->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Phòng số:</strong> {{ $bookingRoom->name }}</p>
                                        <p><strong>Giá mỗi đêm:</strong> {{ number_format($bookingRoom->pivot->price_per_night, 0, ',', '.') }} VNĐ</p>
                                        <p><strong>Số đêm:</strong> {{ $bookingRoom->pivot->number_of_nights }}</p>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>

                @if($booking->bookingServices->count())
                    <div class="card shadow-lg mb-4">
                        <div class="card-header bg-info text-white fw-semibold">
                            Dịch vụ kèm theo
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                @foreach($booking->bookingServices as $bs)
                                    <li>{{ $bs->service->name }} - {{ number_format($bs->service->price, 0, ',', '.') }} VNĐ</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-success text-white fw-semibold">
                        Thanh toán
                    </div>
                    <div class="card-body">
                        <h4 class="text-success">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</h4>
                        <p><strong>Phương thức:</strong>
                            {{ $booking->payment_method == 0 ? 'Thanh toán tại khách sạn' : 'Thanh toán online' }}
                        </p>
                        @if ($booking->payment_method == 0)
                            <p class="text-warning">Bạn sẽ thanh toán khi nhận phòng.</p>
                        @else
                            <p class="text-success">Bạn đã thanh toán online.</p>
                        @endif

                        <p><strong>Trạng thái:</strong> 
                            @if ($booking->status === "pending") 
                                <span class="badge bg-warning text-dark">Đang xử lý</span>
                            @elseif ($booking->status === "confirmed")
                                <span class="badge bg-success">Đã xác nhận</span>
                            @elseif ($booking->status === "cancelled")
                                <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </p>

                        @if ($booking->status === 'pending')
                            @if ($booking->payment_method == 1)
                                <p class="text-info">Bạn đã thanh toán online. Đơn đặt phòng của bạn đang chờ xác nhận.</p>
                            @else
                                <p class="text-danger">Lưu ý: Đặt phòng của bạn đang chờ xác nhận. Vui lòng kiểm tra email để biết thêm chi tiết.</p>
                            @endif
                        @elseif ($booking->status === 'confirmed')
                            <p class="text-success">Đặt phòng của bạn đã được xác nhận. Chúng tôi rất mong được đón tiếp bạn!</p>
                        @endif

                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg me-3">
                        <i class="bi bi-house-door-fill me-1"></i> Về trang chủ
                    </a>
                    <a href="{{ route('booked-rooms.exportPdf', $booking->id) }}" class="btn btn-success btn-lg">
                        <i class="bi bi-file-earmark-arrow-down-fill me-1"></i> Tải hóa đơn (PDF)
                    </a>
                </div>

            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">
            Không tìm thấy thông tin đặt phòng gần đây.
        </div>
    @endif
</div>
@endsection
