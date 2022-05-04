<?php

namespace App\Enums;


class OrderStatus extends BasicEnum
{
    const SEARCH = 'search';
    const PLANNING = 'planning';
    const CANCELED = 'canceled';
    const COMPLETED = 'completed';
    const ACTIVE = 'active';
}