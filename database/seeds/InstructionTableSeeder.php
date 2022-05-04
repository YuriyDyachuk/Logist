<?php

use Illuminate\Database\Seeder;

class InstructionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('instruction')->delete();
        
        \DB::table('instruction')->insert(array (
            0 => 
            array (
                'id' => 13,
                'type' => 1,
                'slug' => 'login',
                'parent_id' => 0,
                'list' => '1',
                'created_at' => '2018-11-01 10:33:49',
                'updated_at' => '2018-11-01 10:36:13',
            ),
            1 => 
            array (
                'id' => 14,
                'type' => 1,
                'slug' => 'register',
                'parent_id' => 13,
                'list' => '1',
                'created_at' => '2018-11-01 10:34:47',
                'updated_at' => '2018-11-01 10:36:20',
            ),
            2 => 
            array (
                'id' => 15,
                'type' => 1,
                'slug' => 'auth',
                'parent_id' => 13,
                'list' => '2',
                'created_at' => '2018-11-01 10:37:52',
                'updated_at' => '2018-11-01 10:37:52',
            ),
            3 => 
            array (
                'id' => 16,
                'type' => 1,
                'slug' => 'profile',
                'parent_id' => 0,
                'list' => '2',
                'created_at' => '2018-11-01 10:49:48',
                'updated_at' => '2018-11-01 10:49:48',
            ),
            4 => 
            array (
                'id' => 17,
                'type' => 1,
                'slug' => 'functions',
                'parent_id' => 0,
                'list' => '3',
                'created_at' => '2018-11-01 10:51:27',
                'updated_at' => '2018-11-01 10:51:27',
            ),
            5 => 
            array (
                'id' => 18,
                'type' => 1,
                'slug' => 'rabochiy-kabinet',
                'parent_id' => 17,
                'list' => '1',
                'created_at' => '2018-11-01 10:53:43',
                'updated_at' => '2018-11-01 10:53:43',
            ),
            6 => 
            array (
                'id' => 19,
                'type' => 1,
                'slug' => 'moya-kompaniya',
                'parent_id' => 17,
                'list' => '2',
                'created_at' => '2018-11-01 10:55:13',
                'updated_at' => '2018-11-01 10:55:13',
            ),
            7 => 
            array (
                'id' => 20,
                'type' => 1,
                'slug' => 'dobavlenie-sotrudnikov',
                'parent_id' => 19,
                'list' => '1',
                'created_at' => '2018-11-01 10:58:14',
                'updated_at' => '2018-11-01 10:58:14',
            ),
            8 => 
            array (
                'id' => 21,
                'type' => 1,
                'slug' => 'transport',
                'parent_id' => 17,
                'list' => '3',
                'created_at' => '2018-11-01 11:35:49',
                'updated_at' => '2018-11-01 11:35:49',
            ),
            9 => 
            array (
                'id' => 22,
                'type' => 1,
                'slug' => 'dobavlenie-novogo-transporta',
                'parent_id' => 21,
                'list' => '1',
                'created_at' => '2018-11-01 11:38:01',
                'updated_at' => '2018-11-01 11:38:01',
            ),
            10 => 
            array (
                'id' => 23,
                'type' => 1,
                'slug' => 'podklyuchenie-transporta-k-driver-app',
                'parent_id' => 21,
                'list' => '2',
                'created_at' => '2018-11-01 11:48:21',
                'updated_at' => '2018-11-01 11:48:38',
            ),
            11 => 
            array (
                'id' => 24,
                'type' => 1,
                'slug' => 'zakazy',
                'parent_id' => 17,
                'list' => '4',
                'created_at' => '2018-11-01 11:51:25',
                'updated_at' => '2018-11-01 11:52:11',
            ),
            12 => 
            array (
                'id' => 25,
                'type' => 1,
                'slug' => 'sozdanie-zakaza',
                'parent_id' => 24,
                'list' => '1',
                'created_at' => '2018-11-01 12:01:55',
                'updated_at' => '2018-11-01 12:01:55',
            ),
            13 => 
            array (
                'id' => 26,
                'type' => 1,
                'slug' => 'aktivatsiya-zakaza',
                'parent_id' => 24,
                'list' => '2',
                'created_at' => '2018-11-01 12:05:51',
                'updated_at' => '2018-11-01 12:09:42',
            ),
            14 => 
            array (
                'id' => 27,
                'type' => 2,
                'slug' => 'faq-example',
                'parent_id' => 0,
                'list' => '1',
                'created_at' => '2018-11-01 12:21:43',
                'updated_at' => '2018-11-01 12:21:43',
            ),
        ));
        
        
    }
}