<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderPaymentTerm extends Model
{
	protected $table = 'order_payment_terms';

    public static function getTerms(){
        $terms = self::all();

        return $terms->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();
    }
}
