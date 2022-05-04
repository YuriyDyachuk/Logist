<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = 'documents_types';

    protected $fillable = ['name', 'code',];

    public $timestamps = false;

    /**
     * @param $name
     * @return DocumentType|Model|null
     */
    public static function search($name)
    {
        return self::where('name', $name)->first();
    }
}
