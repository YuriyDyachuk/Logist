<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->float('amount')->default(0.00);
			$table->string('currency');
			$table->integer('subscription_period')->default(0);
			$table->integer('subscription_id')->default(0);
			$table->string('inner_number')->default('');
			$table->integer('transports')->default(1);
			$table->integer('is_active')->default(0);
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
		Schema::drop('payments');
	}

}
