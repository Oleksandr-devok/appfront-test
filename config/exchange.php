<?php

return [
    'api' => [
        'url' => env('EXCHANGE_RATE_API_URL', 'https://open.er-api.com/v6/latest/USD'),
        'timeout' => env('EXCHANGE_RATE_API_TIMEOUT', 5),
    ],
    'cache' => [
        'key' => env('EXCHANGE_RATE_CACHE_KEY', 'exchange_rate_usd_eur'),
        'ttl' => env('EXCHANGE_RATE_CACHE_TTL', 3600), // 1 hour
    ],
    'default_rate' => env('EXCHANGE_RATE_DEFAULT', 0.85),
]; 