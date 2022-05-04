<?php
/**
 * Author: AmconSoft
 * Author URI: https://www.amconsoft.com/
 * Date: 13.11.2017
 */

namespace App\Traits;

use App\Models\Document\Document;

trait DocumentsRelations
{
    /**
     * Get documents.
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'imagetable');
    }
}