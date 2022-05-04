<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class CategoryType implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('type_id', $value);
    }
}