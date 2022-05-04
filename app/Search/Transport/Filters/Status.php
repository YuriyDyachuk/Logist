<?php

namespace App\Search\Transport\Filters;

use App\Models\Status as StatusModel;
use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Status implements Filter
{
    public static function apply(Builder $builder, $value)
    {
	    if(!is_numeric($value)){
		    $value = StatusModel::where('name', $value)->value('id');
	    }

        return $builder->where('status_id', $value);
    }
}