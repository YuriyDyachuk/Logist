<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';

    protected $fillable = [
        'order_id',
        'name',
        'length',
        'height',
        'width',
        'weight',
        'volume',
        'places',
        'temperature',
        'loading_type_id',
        'package_type_id',
        'hazard_class_id',
        'rolling_stock_type_id'
    ];

    public function loadingType()
    {
        return $this->belongsTo(CargoLoadingType::class, 'loading_type_id');
    }

    public function packageType()
    {
        return $this->belongsTo(CargoPackageType::class, 'package_type_id');
    }

    public function hazardClass()
    {
        return $this->belongsTo(CargoHazardClass::class, 'hazard_class_id');
    }

    public function rollingStockType()
    {
        return $this->belongsTo(\App\Models\Transport\RollingStockType::class, 'rolling_stock_type_id');
    }
}