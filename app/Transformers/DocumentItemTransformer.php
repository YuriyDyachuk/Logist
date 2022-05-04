<?php

namespace App\Transformers;


use App\Models\Document\Document;
use League\Fractal\TransformerAbstract;

class DocumentItemTransformer extends TransformerAbstract
{
    public function transform(Document $document)
    {
        return [
            'id'       => $document->id,
            'name'     => $document->name,
            'filename' => $document->filename,
        ];
    }
}