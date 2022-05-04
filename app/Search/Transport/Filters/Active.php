<?php

namespace App\Search\Transport\Filters;

use App\Models\Status as StatusModel;
use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Active implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('active', $value);
    }
}