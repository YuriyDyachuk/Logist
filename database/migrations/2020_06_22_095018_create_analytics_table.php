<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnalyticsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('analytics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->unsigned();
			$table->integer('driver_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('order_id')->unsigned()->nullable();
			$table->integer('transport_id')->unsigned()->nullable();
			$table->float('distance', 12, 3)->default(0.000);
			$table->float('distance_empty', 12, 3)->default(0.000);
			$table->float('fuel', 10)->default(0.00);
			$table->integer('duration')->unsigned()->default(0);
			$table->float('amount_plan', 10, 0)->default(0);
			$table->dateTime('time');
			$table->boolean('type');
			$table->timestamps();
			$table->float('amount_fact', 10)->default(0.00);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('analytics');
	}

}
