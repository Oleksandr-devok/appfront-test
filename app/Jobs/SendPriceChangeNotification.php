<?php

namespace App\Jobs;

use App\Mail\PriceChangeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPriceChangeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $product;

    protected $oldPrice;

    protected $newPrice;

    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product, $oldPrice, $newPrice, $email)
    {

        // use promoted properties
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->send(new PriceChangeNotification(
                $this->product,
                $this->oldPrice,
                $this->newPrice
            ));

    }
}
