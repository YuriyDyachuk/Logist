<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('user_id');
			$table->integer('acq_id')->nullable();
			$table->string('action')->nullable();
			$table->float('agent_commission')->nullable();
			$table->float('amount')->nullable();
			$table->string('card_token')->nullable();
			$table->dateTime('completion_date')->nullable();
			$table->dateTime('create_date')->nullable();
			$table->string('currency')->nullable();
			$table->string('customer')->nullable();
			$table->string('description')->nullable();
			$table->string('err_code')->nullable();
			$table->string('err_description')->nullable();
			$table->string('liqpay_order_id')->nullable();
			$table->string('order_id')->nullable();
			$table->integer('payment_id')->nullable();
			$table->string('status')->nullable();
			$table->string('token')->nullable();
			$table->string('type')->nullable();
			$table->string('verifycode')->nullable();
			$table->timestamps();
			$table->integer('count_transport')->default(0);
			$table->integer('plan_id')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
	}

}
