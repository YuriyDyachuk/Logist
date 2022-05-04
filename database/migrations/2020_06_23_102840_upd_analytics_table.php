<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('analytics', function (Blueprint $table) {
		    $table->unsignedTinyInteger('expenses_id')->nullable()->after('fuel');
		    $table->float('expenses_amount', 12, 3)->nullable()->after('expenses_id');
		    $table->string('comment')->nullable()->after('expenses_amount');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('analytics', function (Blueprint $table) {
		    $table->dropColumn('expenses_id');
		    $table->dropColumn('expenses_amount');
		    $table->dropColumn('comment');
	    });
    }
}
