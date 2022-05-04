<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('document_role', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('document_id')->unsigned()->index('FK_role_document');
			$table->integer('role_id')->unsigned()->index('FK_document_role');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('document_role');
	}

}
