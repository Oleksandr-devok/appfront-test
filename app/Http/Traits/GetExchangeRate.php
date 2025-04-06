<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;



trait GetExchangeRate
{
    public function getExchangeRate()
    {
        try {
            $response = Http::timeout(5)->get(env('EXCHANGE_RATE_API_URL'));
    
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['rates']['EUR'])) {
                    return $data['rates']['EUR'];
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to connect to exchange rate api: '.$e->getMessage());
        }

        return env('EXCHANGE_RATE', 0.85);
    }
}

