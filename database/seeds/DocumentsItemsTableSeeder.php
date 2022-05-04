<?php

use Illuminate\Database\Seeder;

class DocumentsItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('documents_items')->delete();
        
        \DB::table('documents_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'format' => 'PDF',
                'slug' => 'OrderPDF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}