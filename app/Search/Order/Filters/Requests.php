<?php
/**
 * Created by PhpStorm.
 * User: ams3
 * Date: 13.10.2017
 * Time: 10:53
 */

namespace App\Search\Order\Filters;

use App\Models\Status;
use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;


class Requests implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->whereIn('current_status_id', [Status::whereName('search')->value('id'), Status::whereName('planning')->value('id')]);
    }
}