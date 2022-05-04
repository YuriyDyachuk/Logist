<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCargoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cargo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->index('FK_orders_cargo');
			$table->string('name');
			$table->integer('length');
			$table->integer('height');
			$table->integer('width');
			$table->integer('weight');
			$table->integer('volume');
			$table->integer('places')->nullable();
			$table->string('temperature')->nullable();
			$table->boolean('hazard_class_id')->nullable();
			$table->boolean('loading_type_id')->nullable();
			$table->boolean('package_type_id')->nullable();
			$table->integer('rolling_stock_type_id')->unsigned()->nullable();
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
		Schema::drop('cargo');
	}

}
