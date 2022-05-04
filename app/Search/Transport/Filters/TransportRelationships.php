<?php

namespace App\Search\Transport\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class TransportRelationships implements Filter
{
    public static function apply(Builder $builder, $value)
    {

		if(is_array($value) || $value !== true){
		    return $builder->with($value);
	    }

	    // default кelationships
        return $builder->with([
            'drivers',
        ]);
    }
}