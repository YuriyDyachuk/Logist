<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['filename', 'imagetable_id', 'imagetable_type', 'image_type', 'parent_id', 'path', 'verified'];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Get all of the owning imagetable models.
     */
    public function imagetable()
    {
        return $this->morphTo();
    }
}
