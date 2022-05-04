<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stat_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->comment('company id');
			$table->integer('order_id')->unsigned();
			$table->float('distance', 12, 3);
			$table->float('distance_empty', 12, 3)->nullable();
			$table->float('fuel', 10);
			$table->integer('duration')->unsigned();
			$table->float('amount', 10)->default(0.00);
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
		Schema::drop('stat_orders');
	}

}
