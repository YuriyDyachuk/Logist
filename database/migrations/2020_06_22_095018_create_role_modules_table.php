<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_modules', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('role_id')->unsigned();
			$table->integer('module_id')->unsigned();
			$table->boolean('create')->nullable()->default(0);
			$table->boolean('read')->nullable()->default(0);
			$table->boolean('update')->nullable()->default(0);
			$table->boolean('delete')->nullable()->default(0);
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
		Schema::drop('role_modules');
	}

}
