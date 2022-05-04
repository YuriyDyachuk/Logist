<?php

namespace App\Http\Controllers;

use App\Models\Document\DocumentFields;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Http\Request;

use App\Models\Image;
use App\Models\Document\Document;
use App\Models\Document\DocumentItem;
use App\Models\Document\DocumentForms;
use App\Models\Document\DocumentValues;
use App\Models\Document\DocumentType;
use App\Models\Document\DocumentSign;
use App\Models\User;
use App\Models\Order\Order;

use Auth;
use QRCode;
use Carbon\Carbon;

use App\Enums\DocumentTypes;
use App\Enums\DocumentSignature;

use App\Services\DocumentService;
use App\Services\PDFService;
use App\Services\AmplitudeService;

use App\Jobs\ProcessPdf;

class DocumentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

	    $user = \Auth::user();

	    $query = Document::where('document_type_id', DocumentType::whereName("order_document")->value('id'))
		    ->where('user_id_added', $user->id)
		    ->with('imagetable','documents_form')
		    ->latest();

	    $filters = $request->filters;

//	    if(isset($request->filters['date'])){
//			$date = Carbon::createFromFormat('d/m/Y', $request->filters['date']);
//			$query->whereDate('created_at', $date->format('Y-m-d'));
//	    }

	    if(isset($request->filters['dates'])){
		    $dates = explode('-', $request->filters['dates']);
		    $date_from =  date_format(date_create_from_format('d/m/Y', $dates[0]), 'Y-m-d');
		    $date_to =  date_format(date_create_from_format('d/m/Y', $dates[1]), 'Y-m-d');

		    $query->whereDate('created_at', '>=', $date_from)->where('created_at','<=',$date_to);
	    }

	    $documents = $query->paginate(20);

        $templates = DocumentForms::all();

        return view('documents.index', compact('documents', 'templates', 'filters'));
    }

    public function templateEdit($id){

		$template = DocumentForms::findOrFail($id);

		$template_filename = \Illuminate\Support\Str::snake($template->slug);

        return view('documents.templates.'.$template_filename, compact('id'));
    }

    public function store(Request $request) {
        $user = Auth::user();

		$fields = $request->get('fields');
		$template_id = $request->get('id');

		if(!is_null($fields)){

        foreach($fields as $field_key => $field_value){

	        if(is_null($field_value))
		        continue;

			$form = DocumentFields::whereFormId($template_id)->whereSlug($field_key)->first();

			if(!$form)
				continue;

	        DocumentValues::updateOrCreate(
				['user_id' => $user->id, 'field_id' => $form->id],
		        ['value' => $field_value]);
        }

		}

        return redirect()->route('documents.template.edit', ['id' => $template_id]);
    }

    public function downloadDocument($id, $documentItem)
    {
        $documentItem = DocumentItem::find($documentItem);
//        if ($documentItem->isSigned()) {
//            // Todo: add signed document download
//        }
        return PDFService::order($id);
    }

	public function previewStoredDocument($doc_id)
	{
		$document = Document::findOrFail($doc_id);
		return PDFService::previewStoredDocument($document);
	}

	public function previewDocument($filename)
	{
		$file = public_path() .'/storage/documents/' . $filename;
		$headers = [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; filename="'.$filename.'"'
		];

		return response()->file($file, $headers);
	}

	public function templatePreview(Request $request, $id)
	{
		$template = DocumentForms::findOrFail($id);
		$filename = template_filename($template->slug);
		return PDFService::document_template_preview($id, $filename);
	}

//    public function updateForm(Request $request, $id){
//        $user = Auth::user();
//        $fields = $request->get('field');
//        foreach($fields as $field_id => $field)
//        {
//            $document_value = DocumentValues::firstOrCreate(['user_id' => $user->id, 'field_id' => $field_id]);
//            $document_value->update(['value'=>$field, 'user_id' => $user->id]);
//        }
//
//        return redirect()->back();
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $image    = Image::where('imagetable_id', $id)->where('imagetable_type', Document::class)->first();

        $document->delete();

        if ($image) {
            $image->delete();
            app(File::class)->delete(public_path().'/upload/documents/'.$image->filename);
        }

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'msg' => "<strong>{$document->name}</strong> ". trans('all.deleted_successfully')]);
        }
    }

    public function ajaxSaveGraphSign(Request $request){
	    $this->uploadSignEvent();

    	$signBase64 = $request->file;
    	$document_id = $request->document_id;

	    $filename = 'signature_'.$document_id.'_'.\Illuminate\Support\Str::random(5).'.png';
	    $path = public_path('storage/documents/').$filename;

	    $encoded_image = explode(",", $signBase64)[1];
	    $decoded_image = base64_decode($encoded_image);
	    file_put_contents($path, $decoded_image);

	    $document = Document::findOrFail($document_id);
	    $order_id = $document->imagetable_id;

	    // signature store
	    Document::query()->create([
		    'filename'        => $filename,
		    'user_id_added'   => auth()->id(),
		    'document_type_id'=> DocumentType::whereName("signature")->value('id'),
		    'imagetable_id'   => $document->id,
		    'imagetable_type' => Document::class,
	    ]);

	    //regenerate pdf file
	    dispatch(new ProcessPdf($order_id, auth()->id(), $document->template_id, $document_id));

	    DocumentService::docSignStore(auth()->id(), $document->id, DocumentSignature::GRAPH);

	    return response()->json(['result' => true, 'file' => $path]);
    }

	public function ajaxSaveScanSign(Request $request){
		$this->uploadSignEvent();

		$document_id = $request->document_id;
		$image = $request->file;

		$document = Document::findOrFail($document_id);
		$order_id = $document->imagetable_id;

		DocumentService::save($document, $image, DocumentType::whereName("signature")->value('id'));

		//regenerate pdf file
		dispatch(new ProcessPdf($order_id, auth()->id(), DocumentTypes::REQUEST, $document_id));

		DocumentService::docSignStore(auth()->id(), $document->id, DocumentSignature::SCAN);

		return response()->json(['result' => true, 'file' => '']);
	}

	private function uploadSignEvent(){
		(new AmplitudeService())->simpleRequest('Sign loaded');
	}

    public static function getRequiredDocuments($user_id) {
        return [];
    }
//    todo:to delete
//    public static function generate_filename($filename, $user_id)
//    {
//        return time().rand(10000,99999)."_".$user_id."_".$filename;
//    }
//
//
//    public static function remove_images($user_id, $doc_id = null, $id = null)
//    {
//        $data = Documents::where('user_id', $user_id);
//
//        if($doc_id!=null)
//            $data = $data->where('doc_id', $doc_id);
//
//        if($doc_id!=null)
//            $data = $data->where('id', $id);
//
//
//        $documents = $data->get();
//        foreach($documents as $document)
//        {
//            $file_path = SELF::get_file_path($document->id);
//            unlink($file_path);
//            $document->delete();
//        }
//        return true;
//    }
//
//
//    public static function get_file_path($file_id)
//    {
//        $document = Documents::where('id', $file_id)->first();
//        if(count($document)> 0)
//        {
//            return 'documents/'.$document->filename;
//        }
//        else
//            return '';
//
//    }
//
//
//    public static function after_upload($file_id)
//    {
//        /*
//        $path = SELF::get_file_path($file_name);
//        */
//    }
//
//    public static function get_documents($user_id, $accepted=null, $doc_id=null)
//    {
//        $docs = Documents::where('user_id', $user_id);
//
//        if($accepted!=null || $accepted===0)
//            $docs = $docs->where('accepted', $accepted);
//
//        if($doc_id!=null)
//            $docs = $docs->where('doc_id', $doc_id);
//
//        $result = $docs->get();
//
//        return $result;
//    }
//
//    public static function get_specialization_document($doc_id)
//    {
//
//    }
}
