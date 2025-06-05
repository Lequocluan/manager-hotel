@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách đơn đặt phòng</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đơn đặt phòng</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tổng số: {{ $bookings->total() }} đơn</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('booked-rooms.index') }}" class="row g-2">
                    <div class="col-md">
                        <input type="text" name="name" class="form-control" placeholder="Tên khách hàng" value="{{ request('name') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="{{ request('phone') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="booking_id" class="form-control" placeholder="Tìm mã đơn" value="{{ request('booking_id') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="room_name" class="form-control" placeholder="Tìm số phòng" value="{{ request('room_name') }}">
                    </div>
                    <div class="col-md">
                        <select name="status" class="form-control">
                            <option value="">-- Trạng thái --</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã hoàn tất</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md d-flex">
                        <button type="submit" class="btn btn-primary flex-fill me-2">Lọc</button>
                        <a href="{{ route('booked-rooms.index') }}" class="btn btn-secondary ms-2">Reset</a>
                    </div>
                </form>
            </div>

            @if ($bookings->count() > 0)
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày nhận</th>
                            <th>Ngày trả</th>
                            <th>Số phòng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                {{ $booking->name }}<br>
                                <small class="text-muted">{{ $booking->phone }}</small>
                            </td>
                            <td>{{ $booking->check_in_date->format('d/m/Y') }}</td>
                            <td>{{ $booking->check_out_date->format('d/m/Y') }}</td>
                            <td>
                                @foreach ($booking->rooms as $room)
                                    {{ $room->name }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>{{ number_format($booking->total_price, 0, ',', '.') }}đ</td>
                            <td>
                                @if ($booking->status == 'pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                @elseif ($booking->status == 'confirmed')
                                    <span class="badge bg-primary text-white">Đã xác nhận</span>
                                @elseif ($booking->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @elseif ($booking->status == 'completed')
                                    <span class="badge bg-success">Đã hoàn tất</span>
                                @else
                                    <span class="badge bg-transparent">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('booked-rooms.show', $booking->id) }}" class="btn btn-outline-primary btn-sm" title="Chi tiết">
                                        <i class="fas fa-eye" data-bs-toggle="tooltip" title="Xem chi tiết đơn phòng"></i>
                                    </a>

                                    <form action="{{ route('booked-rooms.destroy', $booking->id) }}" method="POST" class="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-btn" title="Xóa">
                                            <i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa đơn phòng này"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                @if ($isSearching)
                    <p class="alert alert-warning m-3 text-center">Không tìm thấy đơn đặt phòng nào phù hợp với điều kiện tìm kiếm.</p>
                @else
                    <p class="alert alert-danger m-3 text-center">Chưa có đơn đặt phòng nào!</p>
                @endif
            @endif
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection
