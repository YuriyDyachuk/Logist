<?php

namespace App\Search\Transport;

use App\Traits\Search;
use App\Models\Transport\Transport;

class TransportSearch
{
    use Search;

    protected static function pathFilter()
    {
        return __NAMESPACE__ . '\\Filters\\';
    }

    protected static function getModel()
    {
        return new Transport();
    }
}