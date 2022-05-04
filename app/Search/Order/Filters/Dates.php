<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;


class Dates implements Filter
{
    public static function apply(Builder $builder, $value)
    {
		$dates = explode('-', $value);
        $date_from =  date_format(date_create_from_format('d/m/Y', $dates[0]), 'Y-m-d');
        $date_to =  date_format(date_create_from_format('d/m/Y', $dates[1]), 'Y-m-d');

        return $builder->whereDate('orders.created_at', '>=', $date_from)->where('orders.created_at','<=',$date_to);
    }
}