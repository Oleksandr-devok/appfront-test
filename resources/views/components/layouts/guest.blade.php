<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .price-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 1rem;
        }
        .price-usd {
            font-size: 1.5rem;
            font-weight: bold;
            color: #e74c3c;
        }
        .price-eur {
            font-size: 1.2rem;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        {{ $slot }}
    </div>
</body>
</html>
