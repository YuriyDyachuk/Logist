<?php

namespace App\Transformers;


use App\Models\Document\Document;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;

use App\Services\MobileIdService;

class DocumentCollectionTransformer extends TransformerAbstract
{
    public function transform(Document $document)
    {
        return [
            'id'         => $document->id,
            'name'       => $document->name,
            'filename'   => $document->filename,
            'status_sign'=> $document->status_sign = (new MobileIdService())->isSignedMobileId($document->id, $document->template_id),
            'scope'      => ['download'],
//            'downloaded' => $this->getDownloadedDocument($document),
        ];
    }

    /**
     * @param Document $document
     * @return array|null
     */
    public function getDownloadedDocument(Document $document)
    {
        $manager = new Manager;
        $manager->setSerializer(new \App\Services\DataArraySerializer);

        if ($document = Document::query()->where('template_id', $document->id)->first()) {
            $resource = $this->item($document, new DocumentItemTransformer, false);

            return $manager->createData($resource)->toArray();
        }
    }
}