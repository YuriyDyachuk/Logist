<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdSlugDocumentsFormsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents_forms_fields', function (Blueprint $table) {
	        $table->dropUnique('documents_forms_fields_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents_forms_fields', function (Blueprint $table) {
	        $table->unique('slug');
        });
    }
}
