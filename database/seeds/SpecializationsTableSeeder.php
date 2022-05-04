<?php

use Illuminate\Database\Seeder;

class SpecializationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specializations')->delete();
        
        \DB::table('specializations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'car_transport',
                'parent_id' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'railway_transport',
                'parent_id' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'shipping_transport',
                'parent_id' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'air_transport',
                'parent_id' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'multimodal_transport',
                'parent_id' => 0,
            ),
        ));
        
        
    }
}