<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructions extends Model
{
    protected $table = 'instruction';
	protected $fillable = ['type', 'slug', 'text', 'title', 'parent_id', 'list', 'created_at', 'updated_at'];

	public function parent()
	{
		return Instructions::where('id', $this->parent_id);
	}

	public function children()
	{
		return $this->hasMany(Instructions::class,'parent_id')->get();
	}

}
