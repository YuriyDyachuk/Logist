<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransportsDriversTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transports_drivers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('transport_id')->unsigned()->index('FK_transport_driver');
			$table->integer('user_id')->unsigned()->index('FK_driver_transport');
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
		Schema::drop('transports_drivers');
	}

}
