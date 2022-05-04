<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

use App\Enums\OrderStatus;
use App\Models\Status;


class WithOrder implements Filter
{
    public static function apply(Builder $builder, $value)
    {


        if(is_array($value)){
            return $builder->with(
                ['orders' => function($q) use ($value){
                    $q->whereIn('current_status_id', $value);
                }]
            );
        }
        elseif(is_int($value)) {
            return $builder->with(
                ['orders' => function($q) use ($value){
                    $q->where('current_status_id', $value);
                }]
            );
        }

        return $builder->with(
            'orders'
        );
    }
}