<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OfferOrder extends Model
{
    protected $table = "offer_orders";

    protected $fillable = [
        'order_id',
        'amount',
    ];
}
