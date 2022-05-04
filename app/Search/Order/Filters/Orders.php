<?php

namespace App\Search\Order\Filters;


use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

use App\Services\LogisticService;

class Orders implements Filter
{
	public static function apply(Builder $builder, $value)
	{

		if(is_array($value)){

			$user_array = $value;
		} elseif ($value !== true && is_int((int)$value)){
			$user_array = [$value];
		}
		else {
			$user_array = (new LogisticService)->getLogistsArray();
		}

		return $builder->whereHas('performers', function($q) use ($user_array){
			$q->whereIn('user_id', $user_array);
		});
	}
}