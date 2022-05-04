<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->truncate();

        \DB::table('roles')->insert([
            0 =>
                [
                    'id' => 1,
                    'name' => 'logistic',
                    'type' => '0',
                    'parent_id' => '0',
                    'description' => '',
                ],
            1 =>
                [
                    'id' => 2,
                    'name' => 'client',
                    'type' => '0',
                    'parent_id' => '0',
                    'description' => '',
                ],
            2 =>
                [
                    'id' => 3,
                    'name' => 'driver',
                    'type' => '0',
                    'parent_id' => '1',
                    'description' => '',
                ],
            3 =>
                [
                    'id' => 4,
                    'name' => 'logist',
                    'type' => '0',
                    'parent_id' => '1',
                    'description' => '',
                ],
            4 =>
                [
                    'id' => 5,
                    'name' => 'manager',
                    'type' => '0',
                    'parent_id' => '1',
                    'description' => '',
                ],
            5 =>
	            [
		            'id' => 6,
		            'name' => 'cargo_loader',
		            'type' => '0',
		            'parent_id' => '1',
		            'description' => 'кладовщик',
	            ],
            6 =>
	            [
		            'id' => 7,
		            'name' => 'cargo_receiver',
		            'type' => '0',
		            'parent_id' => '1',
		            'description' => 'приемщик',
	            ],
        ]);
        
//        \DB::table('roles')->insert(array (
//            0 =>
//            array (
//                'id' => 1,
//                'name' => 'client-person',
//                'description' => '',
//            ),
//            1 =>
//            array (
//                'id' => 2,
//                'name' => 'client-company',
//                'description' => '',
//            ),
//            2 =>
//            array (
//                'id' => 3,
//                'name' => 'logistic-person',
//                'description' => '',
//            ),
//            3 =>
//            array (
//                'id' => 4,
//                'name' => 'logistic-company',
//                'description' => '',
//            ),
//            4 =>
//            array (
//                'id' => 5,
//                'name' => 'driver',
//                'description' => '',
//            ),
//            5 =>
//                array (
//                    'id' => 6,
//                    'name' => 'logistic-manager',
//                    'description' => '',
//                ),
//        ));
        
        
    }
}