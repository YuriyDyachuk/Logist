<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCargoLoadingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_cargo_loading', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('order_id')->unsigned();
	        $table->integer('loading_type_id')->unsigned();
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
	    Schema::drop('order_cargo_loading');
    }
}
