<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Analytics extends Model
{
    protected $table = 'analytics';

    protected $fillable = [
        'parent_id',
	    'report_id',
        'driver_id',
        'transport_id',
        'user_id',
        'order_id',
        'distance',
        'distance_empty',
        'fuel',
        'fuel_tank',
	    'expenses_id',
	    'expenses_amount',
	    'comment',
        'duration',
        'amount_plan',
        'amount_fact',
        'time',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('time', function (Builder $builder) {
            $builder->orderBy('time', 'desc');
        });
    }

    public function expenses(){
		return $this->belongsTo('App\Models\Analytics\Expenses');
    }
}
