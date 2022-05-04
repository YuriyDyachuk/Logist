<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;

use App\Enums\DocumentSignature;
use App\Models\Document\DocumentSign;

class DocumentService
{
    /**
     * @param Model $model
     * @param UploadedFile $image
     * @param null $documentType
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public static function save(Model $model, UploadedFile $image, $documentType = null)
    {
        $filename = self::move($image);
        $data     = [
            'document_type_id' => $documentType,
	        'user_id_added'    => auth()->id(),
            'filename'         => null,
            'imagetable_id'    => $model->id,
            'imagetable_type'  => get_class($model),
        ];

        if ($document = Document::query()->where($data)->first()) {
            $document->update(['filename' => $filename]);
        } else {
            $data['filename'] = $filename;
            $document = Document::query()->create($data);
        }

        return $document;
    }

    /**
     * @param UploadedFile $image
     * @return string
     */
    public static function move(UploadedFile $image)
    {
        $filename = str_random(40) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/documents/'), $filename);

        return $filename;
    }

    public static function destroyFile($filename, $folder = 'documents'){

		$pathfile = public_path('storage/'.$folder.'/').$filename;

	    if(file_exists($pathfile)){
	    	unlink($pathfile);
	    	return true;
	    }

		return false;
    }

    public static function docSignStore($user_id, $document_id, $signaturin_type = 1){
    	//$signaturin_type 1 = graph
		//$signaturin_type 2 = scan
	    //$signaturin_type 3 = mobile id
	    DocumentSign::create([
		    'user_id' => auth()->id(),
		    'document_id' => $document_id,
		    'signature' => $signaturin_type,
	    ]);
    }

    public static function getGraphSign($document_id){

    }
}