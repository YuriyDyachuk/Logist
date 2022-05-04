<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Category implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('category_id', $value);
    }
}