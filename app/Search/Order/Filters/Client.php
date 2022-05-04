<?php
/**
 * Created by PhpStorm.
 * User: ams3
 * Date: 12.10.2017
 * Time: 14:44
 */

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

use App\Models\ClientOrder;

class Client implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        $user = \Auth::user();

        $client = $user->isUserClient;

        $client_orders_array = [];

        if($client){
            $client_orders = ClientOrder::where('client_id', $client->id)->pluck('order_id');

            if($client_orders->isNotEmpty()) {
                $client_orders_array = $client_orders->toArray();
            }
        }

        return $builder->where(function($q) use ($client_orders_array, $user) {
            $q->whereIn('id', $client_orders_array)
                ->orWhere('user_id', $user->id);
        });

//        return $builder->where('user_id', \Auth::user()->id);
    }
}