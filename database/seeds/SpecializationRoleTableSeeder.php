<?php

use Illuminate\Database\Seeder;

class SpecializationRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specialization_role')->delete();
        
        \DB::table('specialization_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'specialization_id' => 1,
                'role_id' => 3,
                'created_at' => '2017-12-15 14:01:43',
                'updated_at' => '2017-12-15 14:01:43',
            ),
            1 => 
            array (
                'id' => 2,
                'specialization_id' => 1,
                'role_id' => 4,
                'created_at' => '2017-12-15 14:01:43',
                'updated_at' => '2017-12-15 14:01:43',
            ),
            2 => 
            array (
                'id' => 3,
                'specialization_id' => 4,
                'role_id' => 4,
                'created_at' => '2017-12-15 14:01:43',
                'updated_at' => '2017-12-15 14:01:43',
            ),
            3 => 
            array (
                'id' => 4,
                'specialization_id' => 2,
                'role_id' => 4,
                'created_at' => '2017-12-15 14:01:43',
                'updated_at' => '2017-12-15 14:01:43',
            ),
            4 => 
            array (
                'id' => 5,
                'specialization_id' => 3,
                'role_id' => 4,
                'created_at' => '2017-12-15 14:01:43',
                'updated_at' => '2017-12-15 14:01:43',
            ),
            5 => 
            array (
                'id' => 6,
                'specialization_id' => 5,
                'role_id' => 4,
                'created_at' => '2017-12-15 14:01:43',
                'updated_at' => '2017-12-15 14:01:43',
            ),
            6 => 
            array (
                'id' => 7,
                'specialization_id' => 1,
                'role_id' => 3,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            7 => 
            array (
                'id' => 8,
                'specialization_id' => 1,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            8 => 
            array (
                'id' => 9,
                'specialization_id' => 4,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            9 => 
            array (
                'id' => 10,
                'specialization_id' => 2,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            10 => 
            array (
                'id' => 11,
                'specialization_id' => 3,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            11 => 
            array (
                'id' => 12,
                'specialization_id' => 5,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
        ));
        
        
    }
}