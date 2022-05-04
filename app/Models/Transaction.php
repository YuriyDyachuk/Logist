<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
	    'payment_id',
        'user_id',
        'acq_id',
        'action',
        'agent_commission',
        'amount',
        'card_token',
        'completion_date',
        'create_date',
        'currency',
        'customer',
        'description',
        'err_code',
        'err_description',
        'liqpay_order_id',
        'order_id',
        'status',
        'token',
        'type',
        'verifycode',
        'responce',
        'count_transport',
        'plan_id',

    ];
}
