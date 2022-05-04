<?php

use Illuminate\Database\Seeder;

class OrderPaymentTermsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_payment_terms')->delete();
        
        \DB::table('order_payment_terms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'term_original',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'term_prepayment',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'term_unloading',
            ),
            3 =>
            array (
	            'id' => 4,
	            'name' => 'term_scancopies',
            ),
        ));
        
        
    }
}