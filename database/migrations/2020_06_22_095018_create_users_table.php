<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->string('email', 100);
			$table->string('password');
			$table->boolean('verify_email')->default(0);
			$table->boolean('verify_phone')->default(0);
			$table->string('remember_token', 100)->nullable();
			$table->string('social_id', 50)->nullable();
			$table->string('social_type', 50)->nullable();
			$table->string('phone', 20)->nullable();
			$table->boolean('verified')->default(0);
			$table->float('balance')->default(0.00);
			$table->integer('balance_return')->default(0);
			$table->string('referred_by')->nullable()->index();
			$table->boolean('is_activated')->default(0);
			$table->boolean('is_banned')->default(0);
			$table->boolean('invited')->default(0);
			$table->integer('parent_id')->unsigned()->default(0);
			$table->boolean('is_admin')->default(0);
			$table->text('meta_data', 65535)->nullable();
			$table->boolean('type')->nullable()->comment('type of role');
			$table->timestamps();
			$table->string('locale')->default('ru');
			$table->softDeletes();
			$table->dateTime('last_activity')->nullable();
			$table->boolean('tutorial')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
