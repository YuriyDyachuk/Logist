<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Userid implements Filter
{
	public static function apply(Builder $builder, $value)
	{
		return $builder->where('orders.user_id', $value);
	}
}