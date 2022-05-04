<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class CargoHazardClass extends Model
{
    protected $table = "cargo_hazard_classes";

    protected $fillable = [
        'slug',
        'name',
    ];
}