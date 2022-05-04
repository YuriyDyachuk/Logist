<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;

class DocumentUser extends Model
{
	protected $table = 'document_user';

	protected $fillable = ['user_id', 'document_id', 'type', 'verified'];
}
