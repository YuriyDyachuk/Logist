<?php
/**
 * php artisan db:seed --class=DocumentsFormsFieldsTableSeeder
 */


use Illuminate\Database\Seeder;

class DocumentsFormsFieldsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        \DB::table('documents_forms_fields')->delete();

        \DB::table('documents_forms_fields')->insert(array (
            0 => 
	            array (
	                'id' => 1,
	                'form_id' => 1,
	                'slug' => 'order_subject',
	                'type' => 6,
	            ),
            1 => 
	            array (
	                'id' => 2,
	                'form_id' => 1,
	                'slug' => 'order_extra_rules',
	                'type' => 6,
	            ),

            2 =>
	            array (
		            'id' => 3,
		            'form_id' => 2,
		            'slug' => 'order_extra_rules',
		            'type' => 6,
	            ),

            3 =>
	            array (
		            'id' => 4,
		            'form_id' => 3,
		            'slug' => 'order_extra_rules',
		            'type' => 6,
	            ),
            4 =>
	            array (
		            'id' => 5,
		            'form_id' => 4,
		            'slug' => 'order_services',
		            'type' => 6,
	            ),
        ));
        
        
    }
}