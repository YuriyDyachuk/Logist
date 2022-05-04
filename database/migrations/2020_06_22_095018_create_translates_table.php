<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTranslatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('translates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('lang')->nullable();
			$table->integer('type')->unsigned()->nullable();
			$table->integer('item_id')->unsigned()->nullable();
			$table->string('value')->nullable();
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
		Schema::drop('translates');
	}

}
