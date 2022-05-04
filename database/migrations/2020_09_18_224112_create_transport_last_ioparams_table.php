<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportLastIoparamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_last_ioparams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('transport_id',false,true)->length(11)->index();
            $table->integer('ioparam_id',false,true)->length(11)->index();
            $table->string('ioparam_slug',100)->index();
            $table->decimal('ioparam_value',20,10)->default(0);
            $table->string('ioparam_unit',100);
			$table->dateTime('ioparam_datetime')->nullable();
			$table->softDeletes();
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
        Schema::dropIfExists('transport_last_ioparams');
    }
}
