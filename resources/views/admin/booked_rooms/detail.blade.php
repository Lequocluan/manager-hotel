@extends('admin.layout_admin.main')

@section('content')
<div class="container my-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Chi tiết đơn đặt phòng</h3>
        <div>
            <a href="{{ route('booked-rooms.print', $booking->id) }}" target="_blank" class="btn btn-outline-dark me-2">
                <i class="bi bi-printer"></i> In hóa đơn
            </a>
            <a href="{{ route('booked-rooms.exportPdf', $booking->id) }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf"></i> Xuất PDF
            </a>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Thông tin khách hàng</h5>
            <p><strong>Tên:</strong> {{ $booking->name }}</p>
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Điện thoại:</strong> {{ $booking->phone }}</p>
            <p><strong>Ghi chú:</strong> {{ $booking->notes ?? 'Không có' }}</p>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Thời gian lưu trú</h5>
            <p><strong>Ngày nhận phòng:</strong> {{ $booking->check_in_date->format('d/m/Y') }}</p>
            <p><strong>Ngày trả phòng:</strong> {{ $booking->check_out_date->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Dịch vụ sử dụng</h5>
            @if($booking->services->count())
                <ul class="mb-0">
                    @foreach($booking->services as $service)
                        <li>{{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} VNĐ)</li>
                    @endforeach
                </ul>
            @else
                <p><em>Không sử dụng dịch vụ nào.</em></p>
            @endif
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Phòng đã đặt</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Phòng</th>
                            <th>Loại phòng</th>
                            <th>Số đêm</th>
                            <th>Giá / đêm</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking->rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->roomType->name ?? '-' }}</td>
                                <td>{{ $room->pivot ->number_of_nights }}</td>
                                <td>{{ number_format($room -> pivot ->price_per_night, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($room -> pivot ->price_per_night * $room -> pivot ->number_of_nights, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Thông tin thanh toán</h5>
            <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</span></p>
            <p><strong>Phương thức thanh toán:</strong> {{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</p>
            <p><strong>Trạng thái:</strong> 
                @if($booking->status === 'pending')
                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                @elseif($booking->status === 'confirmed')
                    <span class="badge bg-success">Đã xác nhận</span>
                @elseif($booking->status === 'cancelled')
                    <span class="badge bg-danger">Đã hủy</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                @endif
            </p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('booked-rooms.index') }}" class="btn btn-secondary">
            ← Quay lại danh sách
        </a>
    </div>
</div>
@endsection
