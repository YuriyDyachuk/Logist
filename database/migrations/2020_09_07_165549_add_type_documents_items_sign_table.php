<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeDocumentsItemsSignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents_items_sign', function (Blueprint $table) {
	        $table->unsignedTinyInteger('signature')->after('document_id')->comment('1 - graph, 2 - mobile id');
	        $table->integer('document_item_id')->nullable()->change();
        });

	    Schema::rename('documents_items_sign', 'documents_sign');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

	    Schema::rename('documents_sign', 'documents_items_sign');

        Schema::table('documents_items_sign', function (Blueprint $table) {
	        $table->dropColumn('signature');
	        $table->integer('document_item_id')->nullable(false)->change();          //
        });
    }
}
