<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class RollingStock implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('rolling_stock_type_id', $value);
    }
}