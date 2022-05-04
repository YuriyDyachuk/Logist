<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderPaymentType extends Model
{
	protected $table = 'order_payment_types';

	public static function getTypes(){
	    $types = self::all();

        return $types->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();
    }
}
