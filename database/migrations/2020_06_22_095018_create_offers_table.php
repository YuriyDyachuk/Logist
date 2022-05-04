<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->index('FK_offers_order');
			$table->integer('sender_user_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->integer('user_id')->unsigned()->index('FK_offers_user');
			$table->float('price', 10, 0)->nullable();
			$table->boolean('payment_type_id')->nullable();
			$table->boolean('payment_term_id')->nullable();
			$table->boolean('vat')->nullable();
			$table->float('amount_plan')->nullable();
			$table->float('amount_fact')->nullable();
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
		Schema::drop('offers');
	}

}
