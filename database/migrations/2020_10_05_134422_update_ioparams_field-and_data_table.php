<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIoparamsFieldAndDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ioparams', function (Blueprint $table) {
            $table->decimal('ioparam_offset', 15, 5)->default(0)->after('discreteness');
			$table->boolean('can_be_zero')->default(0)->after('ioparam_offset');
        });

        Schema::table('transports', function (Blueprint $table) {
            $table->integer('tank_volume', false, false)->default(0)->after('volume');
        });
        
        \DB::table('ioparams')->truncate();
        \DB::table('transports')->where('id', 264)->update(['tank_volume' => 1500]);
        \DB::table('transports')->where('id', 168)->update(['tank_volume' => 1500]);
        \DB::table('transports')->where('id', 272)->update(['tank_volume' => 1280]);
        \DB::table('transports')->where('id', 270)->update(['tank_volume' => 1280]);
        \DB::table('transports')->where('id', 268)->update(['tank_volume' => 1500]);
        \DB::table('ioparams')->insert(array (
            0 => 
            array (
                'id' => 1,
                'io_id' => -111,
                'ioa_id' => 145,
                'discreteness' => 0.4,
                'ioparam_offset' => 0,
                'can_be_zero' => 0,
                'units' => '%',
                'slug' => 'fuel_level',
                'name' => 'Уровень топлева',
            ),
            1 => 
            array (
                'id' => 2,
                'io_id' => -110,
                'ioa_id' => 146,
                'discreteness' => 0.4,
                'ioparam_offset' => 0,
                'can_be_zero' => 0,
                'units' => '%',
                'slug' => 'oil_level',
                'name' => 'Уровень масла двигателя',
            ),
            2 =>
            array (
                'id' => 3,
                'io_id' => -109,
                'ioa_id' => 147,
                'discreteness' => 1,
                'ioparam_offset' => -40,
                'can_be_zero' => 0,
                'units' => 'С',
                'slug' => 'engine_temperature',
                'name' => 'Температура двигателя',
            ),
            3 =>
            array (
	            'id' => 4,
                'io_id' => -108,
                'ioa_id' => 148,
                'discreteness' => 0.03125,
                'ioparam_offset' => -40,
                'can_be_zero' => 0,
                'units' => 'C',
                'slug' => 'сabin_temperature',
                'name' => 'Температура в кабине',
            ),
            4 =>
            array (
	            'id' => 5,
                'io_id' => -107,
                'ioa_id' => 149,
                'discreteness' => 0.125,
                'ioparam_offset' => 0,
                'can_be_zero' => 1,
                'units' => 'об. в мин',
                'slug' => 'engine_speed',
                'name' => 'Обороты двигателя',
            ),
            5 =>
            array (
	            'id' => 6,
                'io_id' => -106,
                'ioa_id' => 150,
                'discreteness' => 0.005,
                'ioparam_offset' => 0,
                'can_be_zero' => 0,
                'units' => 'км',
                'slug' => 'mileage',
                'name' => 'Пробег ТС',
            ),
            6 =>
            array (
	            'id' => 7,
                'io_id' => -105,
                'ioa_id' => 151,
                'discreteness' => 10,
                'ioparam_offset' => 0,
                'can_be_zero' => 0,
                'units' => 'кг',
                'slug' => 'weight_ts',
                'name' => 'Вес ТС без прицепа',
            ),
            7 =>
            array (
	            'id' => 8,
                'io_id' => -104,
                'ioa_id' => 152,
                'discreteness' => 0.00390625,
                'ioparam_offset' => 0,
                'can_be_zero' => 1,
                'units' => 'км/ч.',
                'slug' => 'speed_by_tachograph',
                'name' => 'Скорость ТС по тахографу',
            ),
            8 =>
            array (
	            'id' => 9,
                'io_id' => -103,
                'ioa_id' => 153,
                'discreteness' => 0.001,
                'ioparam_offset' => 0,
                'can_be_zero' => 0,
                'units' => 'л.',
                'slug' => 'sum_fuel_consumption_l',
                'name' => 'Суммарный расход топлива высокого разрешения',
            ),
        ));        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ioparams', function (Blueprint $table) {
            $table->dropColumn('ioparam_offset');
            $table->dropColumn('can_be_zero');
        });

        Schema::table('transports', function (Blueprint $table) {
            $table->dropColumn('tank_volume');
        });

    }
}
