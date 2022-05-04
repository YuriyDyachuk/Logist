<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('place_id', 65535);
			$table->text('address', 65535);
			$table->text('name', 65535);
			$table->string('house', 190);
			$table->string('street', 190);
			$table->string('city', 190);
			$table->string('state', 190);
			$table->string('country', 190);
			$table->integer('type')->default(1);
			$table->decimal('lat', 10, 8);
			$table->decimal('lng', 11, 8);
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
		Schema::drop('addresses');
	}

}
