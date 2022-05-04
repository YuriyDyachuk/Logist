<?php

use Illuminate\Database\Seeder;

class PaymentsTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payments_types')->delete();
        
        \DB::table('payments_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'rate',
                'type' => 'staff',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'percent',
                'type' => 'staff',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'rate_percent',
                'type' => 'staff',
            ),
        ));
        
        
    }
}