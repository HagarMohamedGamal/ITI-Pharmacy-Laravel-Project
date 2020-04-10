<?php

namespace App\Console\Commands;

use App\User;
use App\Order;
use App\Pharmacy;
use App\UserAddress;
use Illuminate\Console\Command;
use phpDocumentor\Reflection\Types\Null_;

class NewOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:new-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get New Orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::where('pharmacy_id', Null)->get();
        
        foreach ($orders as $order) {
            $order->pharmacy_id = Pharmacy::where(
                'area_id', UserAddress::find($order->useraddress_id)->area_id)
                ->orderby('priority', 'desc')
                ->first()
                ->id;
            $order->save();
        }
    }
}
