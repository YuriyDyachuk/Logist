<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Text implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder
            ->where(function ($query) use ($value) {
                return $query
                    ->where('number', 'LIKE', '%' . $value . '%')
                    ->orWhere('model', 'LIKE', '%' . $value . '%')
                    ->orWhere('tonnage', 'LIKE', '%' . $value . '%');
            });
    }
}