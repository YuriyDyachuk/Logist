<?php
/**
 * Created by PhpStorm.
 * User: CrossRoad
 * Date: 15.12.2017
 * Time: 12:53
 */

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class TransportNumber implements Filter
{
	public static function apply(Builder $builder, $value)
	{
		$orders_ids = [];
		$orders = $builder->get();
		if($orders) {
			foreach($orders as $item) {
				if(!empty($value)) {

					$transport = $item->geoTransport();

					if($transport) {
						$pos = strpos($transport->number, $value);
						if($pos !== false) $orders_ids[] = $item->id;
					}

				}
			}
		}

		return $builder->whereIn('orders.id', $orders_ids);

	}
}