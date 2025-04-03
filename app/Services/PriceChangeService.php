<?php

namespace App\Services;

use App\Jobs\SendPriceChangeNotification;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class PriceChangeService
{
    /**
     * Notify about a price change for a product
     *
     * @param Product $product
     * @param float $oldPrice
     * @param float $newPrice
     * @return bool
     */
    public function notifyPriceChange(Product $product, float $oldPrice, float $newPrice): bool
    {
        if ($oldPrice == $newPrice) {
            return false;
        }

        $notificationEmail = config('app.price_notification_email', 'admin@example.com');

        try {
            SendPriceChangeNotification::dispatch(
                $product,
                $oldPrice,
                $newPrice,
                $notificationEmail
            );
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to dispatch price change notification: ' . $e->getMessage());
            return false;
        }
    }
}