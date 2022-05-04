<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Geo extends Model
{
    protected $table = 'geo';

    protected $fillable = ['transport_id', 'order_id', 'user_id', 'lat', 'lng', 'speed', 'ignition', 'odometer', 'deviation', 'fuel', 'data', 'gps_type_id', 'datetime', 'status_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('geodatetimesort', function (Builder $builder) {
            $builder->orderBy('datetime', 'desc');
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsTo('App\Models\Order\Order');
    }
}
