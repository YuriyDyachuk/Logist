<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;


class RelationshipsRequest implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->with([
            'cargo',
            'addresses',
            'transports',
            'status',
            'offers',
            'offers.creator',
            'offers.executor',
        ]);
    }
}