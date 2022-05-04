<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('filename')->nullable();
			$table->integer('user_id_added')->unsigned()->nullable();
			$table->integer('template_id')->unsigned()->default(0);
			$table->integer('document_type_id')->unsigned()->nullable();
			$table->integer('imagetable_id');
			$table->string('imagetable_type');
			$table->boolean('verified')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('documents');
	}

}
