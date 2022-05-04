<?php

use Illuminate\Database\Seeder;

class DocumentsTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('documents_types')->delete();
        
        \DB::table('documents_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'technical_passport_transport',
                'code' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'driver\'s_license',
                'code' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'registration_company',
                'code' => 3,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'bank_statements',
                'code' => 4,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'passport',
                'code' => 5,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'order_document',
                'code' => 6,
            ),
            6 =>
	            array (
		            'id' => 7,
		            'name' => 'signature',
		            'code' => 7,
	            ),
        ));
        
        
    }
}