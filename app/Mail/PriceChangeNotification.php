<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PriceChangeNotification extends Mailable
{


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected $product,  protected $oldPrice, protected $newPrice) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Product Price Change Notification')
            ->view('emails.price-change')->with([
                'product' => $this->product,
                'oldPrice' => $this->oldPrice,
                'newPrice' => $this->newPrice,
            ]);;
    }
}
