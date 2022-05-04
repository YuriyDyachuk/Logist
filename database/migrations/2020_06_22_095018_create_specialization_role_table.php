<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecializationRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specialization_role', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('specialization_id')->unsigned()->index('FK_specialization_role');
			$table->integer('role_id')->unsigned()->index('FK_role_specialization');
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
		Schema::drop('specialization_role');
	}

}
