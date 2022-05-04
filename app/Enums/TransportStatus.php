<?php

namespace App\Enums;


class TransportStatus extends BasicEnum
{
    const FLIGHT = 'on_flight';
    const REPAIR = 'on_repair';
    const FREE = 'free';
    const INACTIVE = 'inactive';
}