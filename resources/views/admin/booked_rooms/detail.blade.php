@extends('admin.layout_admin.main')

@section('content')
<form action="{{ route('booked-rooms.update', $booking->id) }}" method="POST">
    @csrf
    @method('PUT')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"> Chi tiết đơn đặt phòng</h3>
        <div>
            <a href="{{ route('booked-rooms.print', $booking->id) }}" target="_blank" class="btn btn-outline-dark me-2 btn-lg">
                <i class="bi bi-printer me-1"></i> In hóa đơn
            </a>
            <a href="{{ route('booked-rooms.exportPdf', $booking->id) }}" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-file-earmark-pdf me-1"></i> Xuất PDF
            </a>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-lg rounded-4">
        <div class="card-body">
            <h5 class="card-title text-uppercase text-secondary">Thông tin khách hàng</h5>
            <div class="row">
                <div class="col-md-6"><p><strong>Họ tên:</strong> {{ $booking->name }}</p></div>
                <div class="col-md-6"><p><strong>Email:</strong> {{ $booking->email }}</p></div>
                <div class="col-md-6"><p><strong>Điện thoại:</strong> {{ $booking->phone }}</p></div>
                <div class="col-md-6"><p><strong>Ghi chú:</strong> {{ $booking->notes ?? 'Không có' }}</p></div>
            </div>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-lg rounded-4">
        <div class="card-body">
            <h5 class="card-title text-uppercase text-secondary">Thời gian lưu trú</h5>
            <p><strong>Ngày nhận phòng:</strong> {{ $booking->check_in_date->format('d/m/Y') }}</p>
            <p><strong>Ngày trả phòng:</strong> {{ $booking->check_out_date->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-lg rounded-4">
        <div class="card-body">
            <h5 class="card-title text-uppercase text-secondary">Dịch vụ sử dụng</h5>
            @if($booking->services->count())
                <ul class="mb-0">
                    @foreach($booking->services as $service)
                        <li>{{ $service->name }} - <span class="text-muted">{{ number_format($service->price, 0, ',', '.') }} VNĐ</span></li>
                    @endforeach
                </ul>
            @else
                <p><em>Không sử dụng dịch vụ nào.</em></p>
            @endif
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-lg rounded-4">
        <div class="card-body">
            <h5 class="card-title text-uppercase text-secondary">Phòng đã đặt</h5>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-dark">
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
                                <td>{{ $room->pivot->number_of_nights }}</td>
                                <td>{{ number_format($room->pivot->price_per_night, 0, ',', '.') }} VNĐ</td>
                                <td class="text-danger fw-bold">{{ number_format($room->pivot->price_per_night * $room->pivot->number_of_nights, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h5 class="card-title text-uppercase text-secondary mb-4">Thông tin thanh toán</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tổng tiền:</label>
                    <p class="text-danger fs-5 fw-bold">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</p>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Phương thức thanh toán:</label>
                    <p class="mb-0">{{ $booking->payment_method == 0 ? 'Thanh toán khi nhận phòng' : 'Thanh toán online' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-bold">Trạng thái đơn</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Đã hoàn tất</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label fw-bold">Trạng thái thanh toán</label>
                    @if ($booking->payment_method == 1)
                        <p class="form-control-plaintext text-success fw-bold">Đã thanh toán</p>
                        <input type="hidden" name="payment_status" value="1">
                    @else
                        <select name="payment_status" id="payment_status" class="form-select">
                            <option value="0" {{ $booking->payment_status == 0 ? 'selected' : '' }}>Chưa thanh toán</option>
                            <option value="1" {{ $booking->payment_status == 1 ? 'selected' : '' }}>Đã thanh toán</option>
                        </select>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 d-flex justify-content-between">
        <a href="{{ route('booked-rooms.index') }}" class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-circle"></i> Cập nhật đơn
        </button>
    </div>
</div>
</form>
@endsection

@section('css')
<style>
    .card-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #495057;
}

</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection
