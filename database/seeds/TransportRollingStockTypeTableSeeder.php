<?php

use Illuminate\Database\Seeder;
use App\Models\Transport\Category;
use App\Models\Transport\RollingStockType;

class TransportRollingStockTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        $categoryTruck       = Category::where('name', 'truck')->first();
        $categoryTrailer     = Category::where('name', 'trailer')->first();
        $categorySemitrailer = Category::where('name', 'semitrailer')->first();
        $categorySpecial     = Category::where('name', 'special_machinery')->first();

        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'tilt')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'refrigerator')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'thermo')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'van')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'manipulator')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'dropside')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'platform')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'dump_truck')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'tank_truck')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'petrol_tanker')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'flour_tanker')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'feed_tanker')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'cement_tanker')->first());
        $categoryTruck->rollingStockType()->attach(RollingStockType::where('name', 'milk_tanker')->first());


        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'tilt')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'refrigerator')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'thermo')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'van')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'dropside')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'car_carrier')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'grain_carrier')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'timber_truck')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'platform')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'dump_truck')->first());
        $categoryTrailer->rollingStockType()->attach(RollingStockType::where('name', 'petrol_tanker')->first());

        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'tilt')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'refrigerator')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'thermo')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'van')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'dropside')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'container_chassis')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'timber_truck')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'slabs_carrier')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'platform')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'dump_truck')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'tank_truck')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'petrol_tanker')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'chemical_tanker')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'gas_tanker')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'feed_tanker')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'milk_tanker')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'cement_tanker')->first());
        $categorySemitrailer->rollingStockType()->attach(RollingStockType::where('name', 'flour_tanker')->first());

        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'car_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'grain_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'timber_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'horse_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'crane')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'garbage_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'poultry_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'animal_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'glass_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'pipe_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'tow_transport')->first());
        $categorySpecial->rollingStockType()->attach(RollingStockType::where('name', 'yacht_transporter')->first());
    }
}