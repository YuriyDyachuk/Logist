<?php

use Illuminate\Database\Seeder;
use \App\Models\Order\Order;

class OrderInnerIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::all()->each(function ($order) {

            $max_inner = Order::where('user_id', $order->user_id)->max('inner_id');
            if(is_null($max_inner)) {
                $max_inner = 1;
            } else {
                $max_inner++;
            }

            $order->update(['inner_id' => $max_inner]);
        });
    }
}
