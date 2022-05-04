<?php

namespace App\Models\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class Payment extends Model
{
	protected $table = 'payments';

	protected $fillable = [
		'user_id',
		'amount',
		'currency',
		'subscription_id',
		'subscription_period',
		'inner_number',
		'is_active',
		'transports',
	];

	public function getUser()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}

}
