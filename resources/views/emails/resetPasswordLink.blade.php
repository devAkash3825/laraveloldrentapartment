<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            background-color: #f7f7f7;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
        }

        p {
            font-size: 16px;
            color: #555555;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 20px;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .otp-box {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #f0f8ff;
            border: 1px dashed #007bff;
            border-radius: 5px;
        }

        .btn {
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="https://www.rentapartments.info/Gallery/logo/1/logovitalg.png" alt="Company Logo" class="logo">
        <h1>Verify Your OTP</h1>

        <p>Dear {{ $details['email'] }},</p>

        <p>We have received a request to verify your email address. Please use the One-Time Password (OTP) below to
            proceed:</p>

        <div class="otp-box">
            {{ $details['otp'] }}
        </div>

        <p>This OTP is valid for the next 15 minutes. If you did not request this verification, please ignore this
            email.</p>

        <a href="{{ url('/') }}" class="btn">Go to Our Website</a>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
