<?php

namespace App\Enums;

class SubscriptionsTypes extends BasicEnum
{
	const PAID = 'paid';
	const FREE = 'free';

	const DEFAULT_CURRENCY = "UAH";

	const STATUS_LOW        = 'low';
	const STATUS_MIDDLE     = 'middle';
	const STATUS_TOP        = 'top';

}