<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Type implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        if ($value == 'auto') {
            return $builder->whereIn('type_id', function ($query) {
                return $query->select('cat.id')
                    ->from('transport_category as cat')
                    ->where('cat.name', 'truck')
                    ->orWhere('cat.name', 'tractor');
            });
        }

        if ($value == 'trailer') {
            return $builder->whereIn('type_id', function ($query) {
                return $query->select('cat.id')
                    ->from('transport_category as cat')
                    ->where('cat.name', 'trailer')
                    ->orWhere('cat.name', 'semitrailer');
            });
        }

        if (is_string($value)) $value = (array)$value;

        return $builder->whereIn('type_id', $value);
    }
}