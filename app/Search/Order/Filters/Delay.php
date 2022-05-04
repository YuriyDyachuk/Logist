<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;


class Delay implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where(function ($query) {
            $query
                ->whereExists(function ($query) {
                    $query
                        ->whereRaw('JSON_CONTAINS(show_without_delay->"$.usersId", "'.\Auth::user()->id.'")');
                })
                ->orWhereNotExists(function ($query) {
                    $query->where('show_without_delay->available_at', '>', time());
                })
                ->orWhereNull('show_without_delay');
//                ->whereNull('show_without_delay');
        });
    }
}