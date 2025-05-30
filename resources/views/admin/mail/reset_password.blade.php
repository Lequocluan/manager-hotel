<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu cho tài khoản quản trị Havana.</title>
    <style>
        /* Mobile responsiveness */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                padding: 20px !important;
            }
            .email-content {
                padding: 20px !important;
            }
            .btn {
                width: 100% !important;
            }
        }
    </style>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #3490dc; padding: 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333;">Yêu cầu đặt lại mật khẩu</h2>
                            <p style="color: #555; line-height: 1.6;">
                                Xin chào,
                            </p>
                            <p style="color: #555; line-height: 1.6;">
                                Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản quản trị khách sạn Havana.
                                Nhấn vào nút bên dưới để tiếp tục:
                            </p>

                            <!-- Button -->
                            <table cellpadding="0" cellspacing="0" width="100%" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" style="background: linear-gradient(90deg, #007bff, #0056b3); color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                                            Đặt lại mật khẩu
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #777; font-size: 14px;">
                                Nếu bạn không thực hiện yêu cầu này, bạn có thể bỏ qua email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f0f0f0; padding: 20px; text-align: center; font-size: 12px; color: #888;">
                            Trân trọng,<br>
                            Havana Team<br>
                            <em>Vui lòng không trả lời email này.</em>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
