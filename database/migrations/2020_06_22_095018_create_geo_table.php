<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('transport_id')->index();
			$table->integer('order_id')->index();
			$table->float('lat', 11, 7);
			$table->float('lng', 11, 7);
			$table->float('speed');
			$table->boolean('ignition')->default(1);
			$table->float('odometer', 12, 3);
			$table->float('fuel', 10);
			$table->text('data')->nullable();
			$table->boolean('gps_type_id')->nullable()->comment('1 - app, 2 - globus gps');
			$table->dateTime('datetime')->nullable();
			$table->boolean('status_id')->nullable();
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
		Schema::drop('geo');
	}

}
