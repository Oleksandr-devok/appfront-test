<?php

namespace App\Jobs;

use App\Mail\PriceChangeNotification;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendPriceChangeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Product $product;
    private float $oldPrice;
    private float $newPrice;
    private string $email;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product, float $oldPrice, float $newPrice, string $email)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
        $this->email = $email;
    }

    /**
     * Maximum number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Timeout for the job in seconds.
     */
    public int $timeout = 10;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->email)
                ->send(new PriceChangeNotification(
                    $this->product,
                    $this->oldPrice,
                    $this->newPrice
                ));
        } catch (Throwable $e) {
            Log::error('Failed to send price change email: ' . $e->getMessage(), [
                'product_id' => $this->product->id ?? null,
                'email' => $this->email,
            ]);

            // Optionally: rethrow to let the job fail and retry
            throw $e;
        }
    }
}
