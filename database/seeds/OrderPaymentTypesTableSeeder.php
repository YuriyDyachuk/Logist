<?php

use Illuminate\Database\Seeder;

class OrderPaymentTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_payment_types')->delete();
        
        \DB::table('order_payment_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'payment_bank',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'payment_card',
            ),
            array (
                'id' => 3,
                'name' => 'payment_combined',
            ),
        ));
        
        
    }
}