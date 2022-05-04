<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Model;

class StatOrder extends Model
{
    protected $table = 'stat_orders';

    protected $fillable = ['user_id', 'order_id', 'distance', 'distance_empty', 'fuel', 'duration', 'amount'];
}
