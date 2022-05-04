<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;

class DocumentSign extends Model
{
    protected $table = 'documents_sign';

	protected $guarded = [];

	protected $hidden = ['document_item_id', 'document_id'];
}
