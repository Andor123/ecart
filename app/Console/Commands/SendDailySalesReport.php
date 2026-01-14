<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailySalesReport;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-sales-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = now()->subDay()->toDateString();
        $orders = Order::whereDate('created_at', $yesterday)->with('orderItems.product')->get();
        $totalSales = $orders->sum('total');
        $totalItems = $orders->sum(function ($order) {
            return $order->orderItems->sum('quantity');
        });
        $reportData = [
            'date' => $yesterday,
            'total_sales' => $totalSales,
            'total_items' => $totalItems,
            'orders' => $orders
        ];
        Mail::to('admin@example.com')->send(new DailySalesReport($reportData));
    }
}
