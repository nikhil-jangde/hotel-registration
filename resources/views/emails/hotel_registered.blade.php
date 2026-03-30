<!DOCTYPE html>
<html>
<head>
    <title>Hotel Registration Successful</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .hotel-info {
            background: #fafafa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome, {{ $hotel['name'] }}!</h1>
    </div>
    <div class="content">
        <p>Hello,</p>
        <p>Your hotel has been successfully registered in our system. Below are the details we have on file:</p>
        
        <div class="hotel-info">
            <p><strong>Hotel Name:</strong> {{ $hotel['name'] }}</p>
            <p><strong>Email:</strong> {{ $hotel['email'] }}</p>
            <p><strong>Phone:</strong> {{ $hotel['phone'] }}</p>
            @if(isset($hotel['address']))
                <p><strong>Address:</strong> {{ $hotel['address'] }}, {{ $hotel['city'] }}, {{ $hotel['country'] }}</p>
            @endif
        </div>

        <p>Thank you for choosing our service!</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
