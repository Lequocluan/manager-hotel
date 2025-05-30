<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phản hồi từ Havana Hotel</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f8fb; margin: 0; padding: 0; }
        .email-container { background-color: white; max-width: 600px; margin: auto; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .header { background-color: #005f73; color: white; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 20px; color: #333; }
        .footer { background-color: #e0f2f1; padding: 20px; text-align: center; font-size: 14px; color: #555; }
        .footer a { color: #005f73; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Havana Hotel Nha Trang</h1>
        </div>
        <div class="content">
            <p>Xin chào {{ $contact->name }},</p>
            <p>Chúng tôi xin phản hồi về chủ đề: <strong>{{ $contact->subject ?? 'Liên hệ' }}</strong> nhận được.</p>

            <p>{!!$messageContent !!}</p>
            <p>Trân trọng,<br>Ban quản trị khách sạn Havana Hotel Nha Trang</p>
        </div>
        <div class="footer">
            <p><strong>Havana Hotel Nha Trang</strong></p>
            <p>38 Trần Phú, TP. Nha Trang, Khánh Hòa</p>
            <p>Điện thoại: (0258) 388 9999 – <a href="https://havanahotel.vn">havanahotel.vn</a></p>
            <p>Cảm ơn quý khách đã liên hệ với chúng tôi. Mong sớm được phục vụ quý khách tại Havana Hotel.</p>
        </div>
    </div>
</body>
</html>
