<!DOCTYPE html>
<html>
<head>
    <title>Price Change Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .price-change {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .old-price {
            color: #dc3545;
            text-decoration: line-through;
        }
        .new-price {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Product Price Change Notification</h2>
        </div>

        <p>Hello,</p>

        <p>We wanted to inform you that the price of the following product has been updated:</p>

        <h3>{{ $product->name }}</h3>
        {{-- add product image --}}
        <div class="price-change">
            <p><strong>Old Price:</strong> <span class="old-price">${{ number_format($oldPrice, 2) }}</span></p>
            <p><strong>New Price:</strong> <span class="new-price">${{ number_format($newPrice, 2) }}</span></p>
        </div>

        <p>Thank you for your attention to this update.</p>

        <p>Best regards,<br>Your Store Team</p>
    </div>
</body>
</html>
