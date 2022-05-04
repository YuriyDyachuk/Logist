<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class User implements Filter
{
    public static function apply(Builder $builder, $value)
    {
		if(is_array($value)){
		    return $builder->whereIn('transports.user_id', $value);
	    }

        return $builder->where('transports.user_id', $value);
    }
}