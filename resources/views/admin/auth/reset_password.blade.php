<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu - Havana Hotel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* giữ nguyên style bạn đã có */
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #00a9ce, #005b94);
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
        input {
            width: 420px;
            padding: 12px;
            margin: 10px 0;
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
        input.is-invalid {
    border-color: #e3342f; 
    background-color: #ffe6e6; 
}

.invalid-feedback {
    color: #e3342f;
    font-size: 13px;
    margin-top: -8px;
    margin-bottom: 10px;
    text-align: left;
    padding-left: 6px;
    font-weight: 600;
}

    </style>
</head>
<body>
<div class="container">
    <img src="/admin_asset/img/logo.png" alt="Havana Logo" class="logo">
    <h2>Đặt lại mật khẩu</h2>
    <p class="description">Hệ thống quản trị khách sạn Havana</p>

    <form method="POST" action="{{ route('admin.reset-password') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}"> 
        
        <input class="@error('password') is-invalid @enderror" type="password" name="password" placeholder="Mật khẩu mới" >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
            
        <input class="@error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" >
        @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        
        <button type="submit">Đặt lại mật khẩu</button>
    </form>

    <div class="note">
        Hãy sử dụng mật khẩu mạnh và không chia sẻ với bất kỳ ai.
    </div>
</div>
</body>
</html>
