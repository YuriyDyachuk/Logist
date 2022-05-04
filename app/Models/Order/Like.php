<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'order_id'];
}
