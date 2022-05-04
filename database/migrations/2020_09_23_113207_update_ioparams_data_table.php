<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIoparamsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transport_last_ioparams', function (Blueprint $table) {
            $table->decimal('ioparam_origin_value', 15, 0)->default(0)->after('ioparam_value');
        });
        \DB::table('ioparams')->truncate();
        
        \DB::table('ioparams')->insert(array (
            0 => 
            array (
                'id' => 1,
                'io_id' => -111,
                'ioa_id' => 145,
                'discreteness' => 0.4,
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
        Schema::table('transport_last_ioparams', function (Blueprint $table) {
            $table->dropColumn('ioparam_origin_value');
        });
        \DB::table('ioparams')->truncate();
        
        \DB::table('ioparams')->insert(array (
            0 => 
            array (
                'id' => 1,
                'io_id' => -111,
                'ioa_id' => 145,
                'discreteness' => 0.4,
                'units' => '%',
                'slug' => 'oil_level',
                'name' => 'Уровень масла двигателя',
            ),
            1 => 
            array (
                'id' => 2,
                'io_id' => -110,
                'ioa_id' => 146,
                'discreteness' => 0.4,
                'units' => '%',
                'slug' => 'fuel_level',
                'name' => 'Уровень топлева %',
            ),
            2 =>
            array (
                'id' => 3,
                'io_id' => -109,
                'ioa_id' => 147,
                'discreteness' => 0.05,
                'units' => 'л/ч',
                'slug' => 'fuel_consumption_per_hour',
                'name' => 'Часовой расход топлива',
            ),
            3 =>
            array (
	            'id' => 4,
                'io_id' => -108,
                'ioa_id' => 148,
                'discreteness' => 0.5,
                'units' => 'л.',
                'slug' => 'fuel_consumption_per_trip',
                'name' => 'Объем расход топлива за рейс',
            ),
            4 =>
            array (
	            'id' => 5,
                'io_id' => -107,
                'ioa_id' => 149,
                'discreteness' => 0.5,
                'units' => 'л.',
                'slug' => 'fuel_consumption_engine',
                'name' => 'Расход топлива двигателем',
            ),
            5 =>
            array (
	            'id' => 6,
                'io_id' => -106,
                'ioa_id' => 150,
                'discreteness' => 0.005,
                'units' => 'км',
                'slug' => 'mileage',
                'name' => 'Пробег',
            ),
            6 =>
            array (
	            'id' => 7,
                'io_id' => -105,
                'ioa_id' => 151,
                'discreteness' => 0.005,
                'units' => 'км',
                'slug' => 'mileage_per_trip',
                'name' => 'Пройденный путь за рейс',
            ),
            7 =>
            array (
	            'id' => 8,
                'io_id' => -104,
                'ioa_id' => 152,
                'discreteness' => 10,
                'units' => 'кг',
                'slug' => 'axle_load',
                'name' => 'Нагрузка на ось',
            ),
            8 =>
            array (
	            'id' => 9,
                'io_id' => -103,
                'ioa_id' => 153,
                'discreteness' => 4,
                'units' => 'кПа',
                'slug' => 'oil_pressure',
                'name' => 'Давление масла двигателя',
            ),
        ));        
    }
}
