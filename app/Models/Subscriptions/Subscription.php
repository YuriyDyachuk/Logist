<?php

namespace App\Models\Subscriptions;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	protected $table = 'subscriptions';

	protected $fillable = [
			'name',
			'position',
			'price',
			'min',
			'limit'
	];
}
