<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('statuses')->delete();
        
        \DB::table('statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'active',
                'type' => 'order',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'completed',
                'type' => 'order',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'canceled',
                'type' => 'order',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'search',
                'type' => 'order',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'planning',
                'type' => 'order',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'on_flight',
                'type' => 'transport',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'free',
                'type' => 'transport',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'inactive',
                'type' => 'transport',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Active',
                'type' => 'user',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Not Active',
                'type' => 'user',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Accepted',
                'type' => 'user',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Not accepted',
                'type' => 'user',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'on_repair',
                'type' => 'transport',
            ),
        ));
        
        
    }
}