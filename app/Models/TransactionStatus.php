<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    protected $table = 'transaction_statuses';

    protected $fillable = [
        'transaction_id',
	    'order_id',
        'status',
        'responce',
    ];
}
