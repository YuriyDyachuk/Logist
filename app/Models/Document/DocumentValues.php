<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Document\DocumentFields;

class DocumentValues extends Model
{
	protected $table = 'documents_forms_values';

	protected $fillable = [
		'user_id',
		'field_id',
		'value',
	];

	public static function getValueBySlug($id, $slug, $user = null){
	    if(is_object($user)) {
            $user_current = $user;
        } else {
            $user_current = auth()->user();
        }

		$field = DocumentFields::whereSlug($slug)->whereFormId($id)->first();

		if(!$field)
			return '';

		$fieldValue = SELF::where('field_id', $field->id)
				->where('user_id', $user_current->id)
				->first();

		return $fieldValue ? $fieldValue->value : '';
	}
}
