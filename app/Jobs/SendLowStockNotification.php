<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;

class SendLowStockNotification implements ShouldQueue
{
    use Queueable;

    public $product;

    /**
     * Create a new job instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('admin@example.com')->send(new LowStockNotification($this->product));
    }
}
