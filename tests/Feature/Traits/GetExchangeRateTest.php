<?php

namespace Tests\Feature\Traits;

use App\Http\Traits\GetExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GetExchangeRateTest extends TestCase
{
    use GetExchangeRate;

    public function test_that_get_exchange_rate_successful_response()
    {
        // Mock the external API response
        Http::fake([
            env('EXCHANGE_RATE_API_URL') => Http::response([
                'rates' => [
                    'EUR' => 0.9,
                ],
            ], 200),
        ]);

        $rate = $this->getExchangeRate();

        $this->assertEquals(0.9, $rate);
    }

    public function test_get_exchange_rate_fallback_on_failure()
    {

        Http::fake([
            env('EXCHANGE_RATE_API_URL') => Http::response([], 500),
        ]);

        $rate = $this->getExchangeRate();

        $this->assertEquals(0.85, $rate);
    }

    public function test_get_exchange_rate_fallback_when_data_is_missing()
    {

        Http::fake([
            env('EXCHANGE_RATE_API_URL') => Http::response([
                'some_other_data' => 'value',
            ], 200),
        ]);

        $rate = $this->getExchangeRate();

        $this->assertEquals(0.85, $rate);
    }

    public function test_get_exchange_rate_api_error_logging()
    {
        Log::spy();

        Http::fake([
            env('EXCHANGE_RATE_API_URL') => Http::response([], 500),
        ]);

        $object = new class
        {
            use GetExchangeRate;
        };

        $object->getExchangeRate();

        Log::shouldHaveReceived('error')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'Failed to connect to exchange rate api:');
            });
    }
}
