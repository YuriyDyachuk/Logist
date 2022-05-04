<?php
/**
 * Created by PhpStorm.
 * User: ams3
 * Date: 10.10.2017
 * Time: 14:20
 */

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

class Status implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('current_status_id', $value);
    }
}