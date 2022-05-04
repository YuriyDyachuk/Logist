<?php

use Illuminate\Database\Seeder;

class DocumentRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('document_role')->delete();
        
        \DB::table('document_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'document_id' => 2,
                'role_id' => 3,
                'created_at' => '2018-01-15 09:08:15',
                'updated_at' => '2018-01-15 09:08:15',
            ),
            1 => 
            array (
                'id' => 2,
                'document_id' => 2,
                'role_id' => 4,
                'created_at' => '2018-01-15 09:08:15',
                'updated_at' => '2018-01-15 09:08:15',
            ),
            2 => 
            array (
                'id' => 3,
                'document_id' => 2,
                'role_id' => 5,
                'created_at' => '2018-01-15 09:08:15',
                'updated_at' => '2018-01-15 09:08:15',
            ),
            3 => 
            array (
                'id' => 4,
                'document_id' => 4,
                'role_id' => 3,
                'created_at' => '2018-01-15 09:08:15',
                'updated_at' => '2018-01-15 09:08:15',
            ),
            4 => 
            array (
                'id' => 5,
                'document_id' => 4,
                'role_id' => 4,
                'created_at' => '2018-01-15 09:08:15',
                'updated_at' => '2018-01-15 09:08:15',
            ),
            5 => 
            array (
                'id' => 6,
                'document_id' => 4,
                'role_id' => 5,
                'created_at' => '2018-01-15 09:08:15',
                'updated_at' => '2018-01-15 09:08:15',
            ),
            6 => 
            array (
                'id' => 7,
                'document_id' => 3,
                'role_id' => 2,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            7 => 
            array (
                'id' => 8,
                'document_id' => 4,
                'role_id' => 2,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            8 => 
            array (
                'id' => 9,
                'document_id' => 5,
                'role_id' => 2,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            9 => 
            array (
                'id' => 10,
                'document_id' => 3,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            10 => 
            array (
                'id' => 11,
                'document_id' => 4,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            11 => 
            array (
                'id' => 12,
                'document_id' => 5,
                'role_id' => 4,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
            12 => 
            array (
                'id' => 13,
                'document_id' => 2,
                'role_id' => 3,
                'created_at' => '2018-09-29 15:14:41',
                'updated_at' => '2018-09-29 15:14:41',
            ),
        ));
        
        
    }
}