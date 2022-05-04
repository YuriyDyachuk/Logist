<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Profitability extends Model
{
    public $timestamps = false;

    protected $fillable = ['order_id', 'amount', 'commission'];
}
