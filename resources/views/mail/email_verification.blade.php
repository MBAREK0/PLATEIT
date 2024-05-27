<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6e6e6; /* Updated background color */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo-text {
            font-size: 36px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: #333333;
        }
        h1 {
            color: #333333;
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 20px;
            line-height: 1.6;
            text-align: center;
        }
        a.button {
            display: inline-block;
            background-color: #3490dc;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-text">PLATEIT</div>
        <h1>Email Verification</h1>
        <p>Hello {{ $notifiable->fullName }},</p>
        <p>Welcome to PLATEIT! Before you start exploring our platform, please verify your email address.</p>
        <p>To verify your email, simply click the button below:</p>
        <a href="{{ $url }}" class="button">Verify Email Address</a>
        <p>If you did not create an account on PLATEIT, you can ignore this email.</p>
        <p>Thank you for joining PLATEIT and enjoy your experience!</p>
    </div>
</body>
</html>
