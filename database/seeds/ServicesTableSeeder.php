<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('services')->delete();
        
        \DB::table('services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'customs_brokerage',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'cargo_insurance',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'warehouse_services',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'door_to_door_delivery',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'loader_services',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'consultancy',
            ),
        ));
        
        
    }
}