<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f5f5f5;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            max-width: 180px;
            margin-bottom: 20px;
        }

        h1 {
            color: #fe5c24;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
        }

        p {
            font-size: 15px;
            color: #555555;
            margin-bottom: 15px;
        }

        .otp-container {
            text-align: center;
            margin: 30px 0;
        }

        .otp-box {
            display: inline-block;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #fe5c24;
            padding: 20px 40px;
            background: linear-gradient(135deg, #fff5f0 0%, #ffe8de 100%);
            border: 2px dashed #fe5c24;
            border-radius: 10px;
        }

        .expiry-note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px 16px;
            border-radius: 4px;
            font-size: 13px;
            color: #856404;
            margin: 20px 0;
        }

        .expiry-note i {
            margin-right: 8px;
        }

        .security-note {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            font-size: 13px;
            color: #666;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #fe5c24 0%, #ff7d4d 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .footer p {
            margin: 5px 0;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="https://www.rentapartments.info/Gallery/logo/1/logovitalg.png" alt="RentApartments Logo" class="logo">
            <h1>Password Reset Request</h1>
            <p class="subtitle">Use the OTP below to reset your password</p>
        </div>

        <p>Hello,</p>

        <p>We received a request to reset the password for your account associated with <strong>{{ $details['email'] }}</strong>.</p>

        <p>Please use the following One-Time Password (OTP) to proceed:</p>

        <div class="otp-container">
            <div class="otp-box">{{ $details['otp'] }}</div>
        </div>

        <div class="expiry-note">
            <strong>⏱ This OTP expires in 15 minutes.</strong><br>
            Do not share this code with anyone.
        </div>

        <div class="security-note">
            <strong>🔒 Security Tip:</strong> If you didn't request this password reset, please ignore this email or contact our support team if you believe your account may be compromised.
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} RentApartments. All rights reserved.</p>
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>

</body>

</html>
