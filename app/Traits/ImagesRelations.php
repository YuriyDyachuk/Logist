<?php

namespace App\Traits\ImagesRelations;

use App\Models\Image;

trait ImagesRelations
{
    /**
     * Get all images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }
}