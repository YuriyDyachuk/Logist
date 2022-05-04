<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class CargoPackageType extends Model
{
    protected $table = "cargo_package_types";

    protected $fillable = [
        'slug',
        'name',
    ];
}