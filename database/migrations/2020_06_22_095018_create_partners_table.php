<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partners', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_one_id')->unsigned();
			$table->integer('user_two_id')->unsigned()->index('partners_user_two_id_foreign');
			$table->boolean('status_id');
			$table->integer('action_user_id')->unsigned();
			$table->timestamps();
			$table->unique(['user_one_id','user_two_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('partners');
	}

}
