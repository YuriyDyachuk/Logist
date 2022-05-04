<?php

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Id implements Filter
{
	public static function apply(Builder $builder, $value)
	{
		return $builder->where('orders.id', $value);
	}
}