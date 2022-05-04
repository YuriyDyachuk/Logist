<?php
/**
 * Created by PhpStorm.
 * User: ams3
 * Date: 12.10.2017
 * Time: 14:44
 */

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

use App\Services\LogisticService;

class Logist implements Filter
{
    public static function apply(Builder $builder, $value)
    {
	    $user_array = (new LogisticService)->getLogistsArray();

        return $builder->whereHas('performers', function($q) use ($user_array){
	        $q->whereIn('user_id', $user_array);
        });
    }
}