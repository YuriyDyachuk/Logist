<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Specialization implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('transport_cat_id', $value);
    }
}