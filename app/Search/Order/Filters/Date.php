<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;


class Date implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        $date =  date_format(date_create_from_format('d/m/Y', $value), 'Y-m-d');

        return $builder->whereDate('orders.created_at', $date);
    }
}