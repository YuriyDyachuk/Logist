<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestimonialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testimonials', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->integer('transport_id')->unsigned();
			$table->integer('driver_id')->unsigned();
			$table->text('comment', 65535)->nullable();
			$table->boolean('rating')->nullable();
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
		Schema::drop('testimonials');
	}

}
