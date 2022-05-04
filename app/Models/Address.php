<?php

namespace App\Models;

use App\Models\Relationships\OrderAddress;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = ['place_id', 'address', 'lat', 'lng', 'name', 'house', 'street', 'city', 'state', 'country', 'type'];

    public function orderAddress($order)
    {
        return $this->hasmany(OrderAddress::class, 'address_id')->where('order_id', $order->id);
    }
}
