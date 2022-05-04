<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;
use App\Models\Document\DocumentValues;
use Auth;

class DocumentFields extends Model
{
	protected $table = 'documents_forms_fields';

	protected $fillable = [
			'form_id',
			'slug',
	];

	public function values(){
		$user = Auth::user();
		return $this->hasOne(DocumentValues::class, 'field_id', 'id')->where('user_id', $user->id);
	}
}
