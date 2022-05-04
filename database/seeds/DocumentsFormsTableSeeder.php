<?php
/**
 * php artisan db:seed --class=DocumentsFormsTableSeeder
 */

use Illuminate\Database\Seeder;

class DocumentsFormsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('documents_forms')->delete();
        
        \DB::table('documents_forms')->insert(array (
            0 => 
	            array (
	                'id' => 1,
	                'slug' => 'OrderRequest', // Заявка
	                'format' => 'PDF',
	                'comment' => 'Заявка',
	                'created_at' => NULL,
	                'updated_at' => NULL,
	            ),
            1 =>
	            array (
		            'id' => 2,
		            'slug' => 'OrderCompletion', // Акт работ
		            'format' => 'PDF',
		            'comment' => 'Акт работ',
		            'created_at' => NULL,
		            'updated_at' => NULL,
	            ),
            2 =>
	            array (
		            'id' => 3,
		            'slug' => 'OrderInvoicePayment', // Счет на оплату
		            'format' => 'PDF',
		            'comment' => 'Счет на оплату',
		            'created_at' => NULL,
		            'updated_at' => NULL,
	            ),
            3 =>
	            array (
		            'id' => 4,
		            'slug' => 'OrderWaybill', // Транспортная накладная
		            'format' => 'PDF',
		            'comment' => 'Транспортная накладная',
		            'created_at' => NULL,
		            'updated_at' => NULL,
	            ),
//            4 =>
//	            array (
//		            'id' => 5,
//		            'slug' => 'OrderWaybill2', // Транспортная накладная
//		            'format' => 'pdf',
//		            'comment' => 'Транспортная накладная #2',
//		            'created_at' => NULL,
//		            'updated_at' => NULL,
//	            ),

        ));
        
        
    }
}