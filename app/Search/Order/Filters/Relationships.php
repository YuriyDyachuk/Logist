<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;


class Relationships implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->with([
            'cargo',
            'addresses',
            'transports',
            'status',
//            'offers',
//            'suitablePerformers',
            'performers',
            'performers.creator',
            'performers.executor',
        ]);
    }
}