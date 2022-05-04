<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class HasOffers implements Filter
{
    public static function apply(Builder $builder, $value)
    {

        $user = \Auth::user();

        $user_id = $user->parent_id == 0 ? $user->id : $user->parent_id;

        return $builder->whereHas('offers', function ($q) use($user_id){
            $q->where('company_id', $user_id);
        });
    }
}