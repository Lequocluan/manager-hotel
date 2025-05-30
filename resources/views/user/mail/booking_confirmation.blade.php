<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đặt phòng - Khách sạn Havana</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #28a745;
        }
        h3 {
            margin-top: 30px;
            color: #007bff;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 6px;
        }
        .footer {
            margin-top: 40px;
            font-style: italic;
        }
        .total {
            font-size: 1.2rem;
            color: #dc3545;
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .table th, .table td {
            border: 1px solid #e9ecef;
            padding: 8px 12px;
            text-align: left;
        }
        .table th {
            background: #f1f3f5;
        }
        .booking-info {
            display: flex;
            gap: 20px; 
        }

        .customer-info,
        .booking-details {
            flex: 1; 
        }

        @media (max-width: 768px) {
            .booking-info {
                flex-direction: column;
            }
        }

    </style>
</head>
<body>
    <div class="container" style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px;">
        <h2>🎉 Xin chào {{ $booking->name }},</h2>

        <p>Cảm ơn bạn đã đặt phòng tại <strong>Khách sạn Havana</strong>! Chúng tôi rất hân hạnh được phục vụ bạn.</p>
        <p>Chúng tôi đã nhận được yêu cầu đặt phòng của bạn với các thông tin sau:</p>

        <div class="booking-info">
            <div class="customer-info">
                <h3>Thông tin khách hàng</h3>
                <ul>
                    <li><strong>Họ tên:</strong> {{ $booking->name ?? 'Không xác định' }}</li>
                    <li><strong>Email:</strong> {{ $booking->email ?? 'Không xác định' }}</li>
                    <li><strong>Số điện thoại:</strong> {{ $booking->phone ?? 'Không xác định' }}</li>
                </ul>
            </div>
            <div class="booking-details">
                <h3>Thông tin đặt phòng</h3>
                <ul>
                    <li><strong>Ngày nhận phòng:</strong> {{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') : 'Không xác định' }}</li>
                    <li><strong>Ngày trả phòng:</strong> {{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') : 'Không xác định' }}</li>
                    <li><strong>Ghi chú:</strong> {{ $booking->notes ?: 'Không có' }}</li>
                </ul>
            </div>
        </div>


        <h3>Chi tiết phòng đã đặt</h3>
        <table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th>Loại phòng</th>
                    <th>Phòng</th>
                    <th>Số đêm</th>
                    <th>Giá/đêm</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                @if($booking->count())
                    @foreach($booking->rooms as $room)
                    <tr>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->roomType->name ?? '-' }}</td>
                        <td>{{ $room->pivot->number_of_nights }}</td>
                        <td>{{ number_format($room->pivot->price_per_night, 0, ',', '.') }}đ</td>
                        <td>{{ number_format($room->pivot->price_per_night * $room->pivot->number_of_nights, 0, ',', '.') }}đ</td>
                    </tr>
                @endforeach

                @else
                    <tr>
                        <td colspan="5" style="text-align:center;">Không có dữ liệu phòng</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if ($booking->bookingServices && $booking->bookingServices->count())
            <h3>Dịch vụ kèm theo</h3>
            <ul>
                @foreach ($booking->bookingServices as $bookingService)
                    <li>{{ $bookingService->service->name ?? 'Không xác định' }} - {{ number_format($bookingService->service->price ?? 0, 0, ',', '.') }}đ</li>
                @endforeach
            </ul>
        @endif

        <h3 style="margin-top: 20px;">Tổng tiền thanh toán: <strong>{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}đ</strong></h3>

        <ul>
            <li><strong>Hình thức thanh toán:</strong> 
                @if(strtoupper($booking->payment_method ?? '') === 'COD')
                    Thanh toán khi nhận phòng
                @else
                    Đã thanh toán online
                @endif
            </li>
            <li><strong>Trạng thái:</strong> 
                @switch($booking->status)
                    @case('pending') Đang chờ xác nhận @break
                    @case('confirmed') Đã xác nhận @break
                    @case('cancelled') Đã hủy @break
                    @case('completed') Đã hoàn tất @break
                    @default Không xác định
                @endswitch
            </li>
        </ul>

        <p style="margin-top: 30px;">Chúng tôi sẽ liên hệ với bạn sớm để xác nhận và cung cấp thêm thông tin về thủ tục nhận phòng.</p>

        <div style="margin-top: 40px; font-size: 14px; color: #555;">
            Trân trọng,<br>
            <strong>Khách sạn Havana</strong><br>
            <small>Địa chỉ: 123 Trần Phú, Nha Trang, Khánh Hòa | Hotline: 1800 9999</small>
        </div>
    </div>
</body>

</html>
