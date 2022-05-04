<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('inner_id')->nullable();
			$table->integer('user_id')->unsigned();
			$table->string('comment')->nullable();
			$table->string('type', 10)->nullable();
			$table->integer('transport_cat_id')->unsigned()->nullable();
			$table->integer('current_status_id')->unsigned()->default(0);
			$table->string('currency', 10)->nullable();
			$table->boolean('payment_type_id')->nullable();
			$table->boolean('payment_term_id')->nullable();
			$table->float('amount_plan', 10)->nullable();
			$table->float('amount_fact', 10)->nullable();
			$table->boolean('is_vat')->nullable();
			$table->text('directions')->nullable();
			$table->text('progress', 65535)->nullable();
			$table->integer('rating_terms')->nullable();
			$table->boolean('register_trans_terms')->nullable()->default(1);
			$table->text('meta_data', 65535)->nullable();
			$table->text('show_without_delay')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->dateTime('completed_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
