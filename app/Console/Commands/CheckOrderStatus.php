<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class CheckOrderStatus extends Command
{
    protected $signature = 'order:check-status';
    protected $description = 'Check the order status and perform an action if not active after 5 minutes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $orders = DB::table('orders')
                    ->where('status', 'inactive')  
                    ->where('created_at', '>=', Carbon::now()->subMinutes(5))  
                    ->get();
        foreach ($orders as $order) {
            if (Carbon::parse($order->created_at)->diffInMinutes(Carbon::now()) >= 5) {
                $this->info('Order ' . $order->id . ' has expired.');
                continue; 
            }
            $this->info('Checking order ' . $order->id);
        }
    }
}