<?php

namespace App\Search\Order;

use App\Models\Order\Order;
use App\Traits\Search;

class OrderSearch
{
    use Search;

    protected static function pathFilter()
    {
        return __NAMESPACE__ . '\\Filters\\';
    }

    protected static function getModel()
    {
        return new Order();
    }
}
