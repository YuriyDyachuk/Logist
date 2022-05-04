<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $table = 'order_statuses';

    protected $fillable = ['order_id', 'status_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order\Order');
    }
}