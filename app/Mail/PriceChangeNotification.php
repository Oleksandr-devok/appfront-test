<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class PriceChangeNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Product $product;
    private float $oldPrice;
    private float $newPrice;

    /**
     * Create a new message instance.
     */
    public function __construct(Product $product, float $oldPrice, float $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this
            ->subject('Product Price Change Notification')
            ->view('emails.price-change')
            ->with([
                'product' => $this->product,
                'oldPrice' => number_format($this->oldPrice, 2),
                'newPrice' => number_format($this->newPrice, 2),
            ]);
    }
}
