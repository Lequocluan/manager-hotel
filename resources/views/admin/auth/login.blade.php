<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Đăng nhập trang quản trị' }}</title>
    
    <link href="/admin_asset/img/logo.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset("admin_asset/css/toastr.min.css") }}">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat|Poppins&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .bg-img {
            background: url(https://images.pexels.com/photos/461940/pexels-photo-461940.jpeg);
            height: 150vh;
            background-size: cover;
            background-position: center;
        }

        .bg-img::after {
            position: absolute;
            content: '';
            top: 0;
            left: 0;
            height: 150%;
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 999;
            width: 370px;
            text-align: center;
            padding: 60px 32px;
            background: rgba(255, 255, 255, 0.04);
            box-shadow: -1px 4px 28px 0px rgba(0, 0, 0, 0.75);
        }

        .content header {
            color: #fff;
            font-size: 33px;
            font-weight: 600;
            margin: 0 0 35px 0;
            font-family: 'Poppins', sans-serif;
        }

        .field {
            position: relative;
            height: 45px;
            width: 100%;
            display: flex;
            background: rgba(255, 255, 255, 0.94);
        }

        .field span {
            color: #222;
            width: 40px;
            line-height: 45px;
            padding: 0 10px;
        }

        .field input {
            height: 100%;
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            color: #222;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

.invalid-feedback {
    color: #c1c939; 
    font-size: 0.875rem; 
    margin-top: 0.25rem;
    display: block; 
    font-style: italic;
}

        .space {
            margin-top: 16px;
        }

        .pass {
            text-align: left;
            margin: 10px 0;
        }

        .pass a {
            color: #fff;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
        }

        .pass:hover a {
            text-decoration: underline;
        }

        input[type="submit"] {
            background: linear-gradient(to right, #0000ff 0%, #6666ff 100%);
            border: 1px solid linear-gradient(to right, #0000ff 0%, #6666ff 100%);
            ;
            color: #fff;
            font-size: 18px;
            letter-spacing: 1px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to left, #0000ff 0%, #6666ff 100%);
        }

        .login {
            color: #fff;
            margin: 20px 0;
            font-family: 'Poppins', sans-serif;
        }

        .link {
            display: flex;
            cursor: pointer;
            color: #fff;
            margin: 0 0 20px 0;
        }

        .link i {
            font-size: 17px;
        }

        .link span {
            font-size: 15px;
            margin-left: 8px;

            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }

        .signup {
            color: #fff;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
        }

        .signup a {
            color: #37ff00;
            text-decoration: none;
        }

        .signup a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="bg-img">
        <div class="content">
            <header>Đăng nhập trang quản trị HAVANA</header>
            <form method="POST" action="{{ route('handleLogin') }}" id="login_form">
                @csrf
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="email" class="@error('email') is-invalid @enderror" name="email" id="email"  placeholder="Nhập email">
                </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input type="password" class="password @error('password') is-invalid @enderror" name="password"  placeholder="Mật khẩu">
                </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                <div class="pass">
                    <a href="{{ route('admin.forgot-password.form') }}">Quên mật khẩu?</a>
                </div>
                <div class="field">
                    <input type="submit" value="Đăng nhập">
                </div>
            </form>
        </div>
    </div>
    @include('admin.layout_admin.script')
</body>
</html>
