<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class IsDriver implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder
            ->join('transports_drivers as td', 'td.transport_id', 'transports.id')
            ->select('transports.*','td.transport_id');
    }
}