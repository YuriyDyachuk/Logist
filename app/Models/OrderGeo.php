<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OrderGeo extends Model
{
    protected $table = 'order_geo';

    protected $fillable = ['transport_id', 'order_id', 'lat', 'lng', 'speed', 'ignition', 'odometer', 'deviation', 'fuel', 'data', 'gps_type_id', 'datetime', 'status_id', 'is_check'];

    protected $hidden = [
        'transport_id', 'order_id', 'speed', 'ignition', 'odometer', 'fuel', 'data', 'gps_type_id', 'datetime', 'is_check'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_time', function (Builder $builder) {
            $builder->orderBy('datetime', 'desc');
        });
    }
}
