<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Tài Khoản</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9; }
        .info { font-size: 16px; color: #333; margin-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; color: #007BFF; text-align: center; }
        .footer { margin-top: 20px; font-size: 14px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <p class="title">Thông Tin Tài Khoản Havana Hotel</p>
        <p class="info">Email: <strong>{{ $email }}</strong></p>
        <p class="info">Mật khẩu: <strong>{{ $password }}</strong></p>
        <p class="footer">Vui lòng đăng nhập và thay đổi mật khẩu để bảo mật tài khoản của bạn.</p>
    </div>
</body>
</html>
