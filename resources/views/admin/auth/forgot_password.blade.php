<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - Havana Hotel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #005b94, #00a9ce);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            max-width: 450px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        h2 {
            color: #005b94;
            margin-bottom: 10px;
        }
        p.description {
            font-size: 15px;
            color: #555;
            margin-bottom: 20px;
        }
        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        button {
            width: 100%;
            background-color: #005b94;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #004473;
        }
        .note {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="/admin_asset/img/logo.png" alt="Havana Logo" class="logo">
    <h2>Quên mật khẩu?</h2>
    <p class="description">Hệ thống quản trị khách sạn Havana</p>

    <form method="POST" action="{{ route('admin.forgot-password.send') }}">
        @csrf
        <input class="@error('email') is-invalid @enderror" style="width:420px;" type="email" name="email" placeholder="Nhập email quản trị viên">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <button type="submit">Gửi liên kết đặt lại mật khẩu</button>
    </form>

    <div class="note">
        Vui lòng kiểm tra email để đặt lại mật khẩu sau khi xác nhận.
    </div>
</div>
</body>
</html>
