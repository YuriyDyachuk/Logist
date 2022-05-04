<?php

use Illuminate\Database\Seeder;

class TransportCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('transport_category')->delete();
        
        \DB::table('transport_category')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'automobile',
                'parent_id' => '0',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'truck',
                'parent_id' => '1',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'tractor',
                'parent_id' => '1',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'trailer',
                'parent_id' => '1',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'semitrailer',
                'parent_id' => '1',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'special_machinery',
                'parent_id' => '1',
            ),
        ));
        
        
    }
}