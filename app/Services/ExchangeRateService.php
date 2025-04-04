<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    public function getExchangeRate(): float
    {
        return Cache::remember(
            config('exchange.cache.key'),
            config('exchange.cache.ttl'),
            function () {
                try {
                    $response = Http::timeout(config('exchange.api.timeout'))
                        ->get(config('exchange.api.url'));

                    if (!$response->successful()) {
                        Log::warning('Exchange rate API error', [
                            'status' => $response->status(),
                            'body' => $response->body()
                        ]);
                        return config('exchange.default_rate');
                    }

                    $data = $response->json();
                    return $data['rates']['EUR'] ?? config('exchange.default_rate');
                } catch (\Exception $e) {
                    Log::error('Exchange rate API error: ' . $e->getMessage());
                    return config('exchange.default_rate');
                }
            }
        );
    }
} 