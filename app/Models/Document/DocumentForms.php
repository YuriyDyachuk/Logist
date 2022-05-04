<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;
use App\Models\Document\DocumentFields;

class DocumentForms extends Model
{
	protected $table = 'documents_forms';

	protected $fillable = [
			'slug',
			'format',
	];

	public function fields(){
		return $this->hasMany(DocumentFields::class, 'form_id', 'id');
	}
}
