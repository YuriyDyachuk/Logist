<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('inner_id')->nullable();
			$table->string('login', 50)->nullable();
			$table->string('password')->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('category_id')->unsigned();
			$table->integer('type_id')->unsigned()->nullable();
			$table->boolean('loading_type_id')->nullable();
			$table->integer('rolling_stock_type_id')->unsigned()->nullable();
			$table->string('number', 30)->nullable();
			$table->string('model', 50)->nullable();
			$table->string('year', 4)->nullable();
			$table->string('condition', 50)->nullable();
			$table->integer('tonnage')->nullable();
			$table->integer('height')->nullable();
			$table->integer('length')->nullable();
			$table->integer('width')->nullable();
			$table->integer('volume')->nullable();
			$table->string('gps_id', 50)->nullable();
			$table->string('insurance', 50)->nullable();
			$table->string('tachograph', 20)->nullable();
			$table->string('monitoring', 10)->nullable();
			$table->boolean('verified')->default(0);
			$table->integer('status_id')->unsigned();
			$table->integer('parent_id')->unsigned()->nullable();
			$table->boolean('coupling')->default(0);
			$table->text('data')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->dateTime('last_login')->nullable();
			$table->boolean('active')->default(0);
			$table->float('lat', 11, 7)->nullable();
			$table->float('lng', 11, 7)->nullable();
			$table->dateTime('current_date')->nullable();
			$table->integer('current_order_id')->nullable();
			$table->float('current_speed');
			$table->text('current_data')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transports');
	}

}
