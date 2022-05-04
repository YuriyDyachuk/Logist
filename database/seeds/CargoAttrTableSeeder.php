<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order\Cargo;
use App\Models\Order\CargoLoadingType;
use App\Models\Order\CargoPackageType;
use App\Models\Order\CargoHazardClass;

class CargoAttrTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cargo = Cargo::all();

        $datetime = new \DateTime();

        // cargo loading type ----------------------------------------------------------------

        CargoLoadingType::query()->truncate();

        $data = [
            'Верхняя' => ['slug' => 'upper',     'name' => 'Верхняя'],
            'Боковая' => ['slug' => 'lateral',   'name' => 'Боковая'],
            'Задняя'  => ['slug' => 'rear',      'name' => 'Задняя'],
        ];

        foreach ($data as $item){
            DB::table('cargo_loading_types')->insert([
                'slug' => $item['slug'],
                'name' => $item['name'],
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        }

        foreach($cargo as $item){
            if($item->loading_type){
                $res = CargoLoadingType::whereName($item->loading_type)->first();
                if($res){
                    Cargo::whereId($item->id)->update(['loading_type_id' => $res->id]);
                }
            }
        }


        // cargo package type ----------------------------------------------------------------

        CargoPackageType::query()->truncate();

        $data = [
            ['slug' => 'plywood_and_wooden_boxes',      'name' => 'Фанерные и деревянные ящики'],
            ['slug' => 'corrugated_cardboard_boxes',    'name' => 'Коробки из гофрированного картона'],
            ['slug' => 'polypropylene_bags',            'name' => 'Мешки из полипропилена'],
        ];

        foreach ($data as $item){
            DB::table('cargo_package_types')->insert([
                'slug' => $item['slug'],
                'name' => $item['name'],
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        }

        foreach($cargo as $item){
            if($item->pack_type){
                $res = CargoPackageType::whereName($item->pack_type)->first();
                if($res){
                    Cargo::whereId($item->id)->update(['package_type_id' => $res->id]);
                }
            }
        }

        // cargo hazard class ----------------------------------------------------------------

        CargoHazardClass::query()->truncate();

        $data = [
            ['slug' => 'gases_compressed_liquefied','name' => 'Газы, сжатые, сжиженные'],
            ['slug' => 'flammable_liquids',         'name' => 'Легковоспламеняющиеся жидкости'],
            ['slug' => 'toxic_substances',          'name' => 'Ядовитые вещества'],
        ];

        foreach ($data as $item){
            DB::table('cargo_hazard_classes')->insert([
                'slug' => $item['slug'],
                'name' => $item['name'],
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        }

        foreach($cargo as $item){
            if($item->hazard_class){
                $res = CargoHazardClass::whereName($item->hazard_class)->first();
                if($res){
                    Cargo::whereId($item->id)->update(['hazard_class_id' => $res->id]);
                }
            }
        }
    }
}
