<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderPerformersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_performers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('sender_user_id')->unsigned();
			$table->integer('transport_id')->unsigned()->nullable();
			$table->boolean('payment_type_id')->nullable();
			$table->boolean('payment_term_id')->nullable();
			$table->boolean('vat')->nullable();
			$table->float('amount_plan')->nullable();
			$table->float('amount_fact')->nullable();
			$table->integer('debtdays')->unsigned()->nullable()->default(0);
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
		Schema::drop('order_performers');
	}

}
