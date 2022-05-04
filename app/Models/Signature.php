<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\SignatureStatus;

class Signature extends Model
{
	protected $fillable = [
		'user_id',
		'role_id',
		'phone',
		'transaction_id',
		'mssp_transaction_id',
		'document_id',
		'filehash',
		'status',
		'signature',
		'cert_info'
	];

	public function statuses()
	{
		return $this->hasMany(SignatureStatus::class);
	}
}
