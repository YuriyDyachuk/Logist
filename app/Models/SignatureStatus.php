<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignatureStatus extends Model
{
	protected $table = 'signatures_statuses';

	protected $fillable = [
		'signature_id',
		'transaction_id',
		'mssp_transaction_id',
		'status',
	];
}
