<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin đặt phòng</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 30px;
        }
        
        .hotel-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .row 
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
            padding: 5px;
        }
        .left, .right {
            width: 50%;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
            text-decoration: underline;
        }
        .info-label {
            font-weight: bold;
        }
        .room-table, .service-table {
            width: 100%;
            border: 1px solid #000;
            margin-top: 10px;
        }
        .room-table th, .room-table td,
        .service-table th, .service-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
            padding-top: 15px;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="hotel-info">
        <h2>HAVANA HOTEL</h2>
        <p>38 Trần Phú, Nha Trang, Khánh Hòa</p>
        <p>Điện thoại: 0258 388 9999 | Email: info@havanahotel.vn</p>
    </div>


    <h2>THÔNG TIN ĐẶT PHÒNG</h2>

    <table>
        <tr>
            <td class="left">
                <div class="section-title">Thông tin khách hàng</div>
                <p><span class="info-label">Họ tên:</span> {{ $booking->name }}</p>
                <p><span class="info-label">Email:</span> {{ $booking->email }}</p>
                <p><span class="info-label">SĐT:</span> {{ $booking->phone }}</p>
                <p><span class="info-label">Ghi chú:</span> {{ $booking->notes ?? 'Không có' }}</p>
            </td>
            <td class="right">
                <div class="section-title">Thông tin đặt phòng</div>
                <p><span class="info-label">Ngày đến:</span> {{ $booking->check_in_date->format('d/m/Y') }}</p>
                <p><span class="info-label">Ngày đi:</span>{{ $booking->check_out_date->format('d/m/Y') }}</p>
                <p><span class="info-label">Phương thức thanh toán:</span> {{ $booking->payment_method == 1 ? 'Thanh toán online' : 'Thanh toán khi nhận phòng' }}</p>
                <p><span class="info-label">Trạng thái:</span> 
                    @switch($booking->status)
                        @case('pending') Chờ xử lý @break
                        @case('confirmed') Đã xác nhận @break
                        @case('completed') Đã hoàn tất @break
                        @case('cancelled') Đã hủy @break
                        @default -
                    @endswitch
                </p>
            </td>
        </tr>
    </table>

    <div class="section-title">Phòng đã đặt</div>
    <table class="room-table">
        <thead>
            <tr>
                <th>Loại phòng</th>
                <th>Phòng</th>
                <th>Giá/đêm</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($booking->rooms as $room)
                <tr>
                    <td>{{ $room->roomType->name }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ number_format($room->roomType->price, 0, ',', '.') }}đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Dịch vụ đi kèm</div>
    <table class="service-table">
        <thead>
            <tr>
                <th>Tên dịch vụ</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($booking->services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ number_format($service->price, 0, ',', '.') }}đ</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Không có dịch vụ đi kèm</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Tổng tiền: {{ number_format($booking->total_price, 0, ',', '.') }}đ
    </div>
    
    <div class="footer">
        <p>Ngày in: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</body>
</html>
