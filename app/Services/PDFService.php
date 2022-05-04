<?php

namespace App\Services;

use Illuminate\Support\Str;

use App\Models\Order\Order;
use App\Models\Transport\Transport;
use App\Services\TransportService;
use App\Models\User;
use QRCode;
use App\Models\Document\DocumentValues;
use App\Models\Document\DocumentFields;
use App\Models\Document\DocumentForms;
//use App\Models\Document\DocumentItem;
use App\Models\Document\Document;

class PDFService{

    private static $userId = null;
    private static $templateId = null;
    private static $templateSlug = null;
    private static $document = null;

	/*
	 * Store template documents to file when order is creating
	 * */
	public static function storeAllDocumentToFile($id, $userId = null){
	    self::$userId = $userId;

		$documentItems = DocumentForms::all();

		if($documentItems){
			foreach ($documentItems as $doc){

				$filename = strtolower($doc->slug).'_'.$id.'_'.Str::random(10).'.'.strtolower($doc->format);
				$result = self::order($id, $filename);

				if($result){
					Document::storeDocumentToDB($id, $doc->id, $doc->slug, $filename, self::$userId);
				}
			}
		}
	}


	/*
	 * Store template document to file
	 * */
	public static function storeDocumentToFile($id, $template_id, $userId = null, $document_id_rewrite = null){
		self::$userId = $userId;
		self::$templateId = $template_id;

		$template = DocumentForms::find($template_id);

		self::$templateSlug = $template->slug;

		$filename = self::generateFileName($template, $id);

		$document = null;

		if($document_id_rewrite){
			$document = Document::find($document_id_rewrite);
			$id = $document->imagetable_id;
			if($document){
				self::$document = $document;
				$filename = $document->filename;
			}
		}

		$method = 'create_'.$template->slug;

		if(!method_exists(self::class, $method))
			return false;

		$result = self::{$method}($id, $filename);

		if($result && $document == null){
			Document::storeDocumentToDB($id, $template->id, $template->slug, $filename, $userId);
		}

		if($result && $document !== null){
			Document::whereId($document->id)->update(['filename' => $filename, 'name' => template_filename($template->slug)]);
		}
	}

	public static function previewStoredDocument($document){

		self::$userId = $document->user_id_added;
		self::$templateId = $document->template_id;
		self::$document = $document;

		$template = DocumentForms::find($document->template_id);

		$id = $document->imagetable_id;

		self::$templateSlug = $template->slug;

		$method = 'create_'.$template->slug;

		if(!method_exists(self::class, $method))
			return false;

		return self::{$method}($id, false, true);
	}

	public static function create_OrderRequest($order_id, $filename = false){
		logger('PDF ORDER ID: '.$order_id);

        $order = Order::find($order_id);

		$templateId = self::$templateId;

        if(self::$userId){
            $user = User::findOrFail(self::$userId);
	        logger('PDF CREATOR JOB: '.$user->id);
        } else {
            $user = \Auth::user();
        }

//		logger('PDF CREATOR: '.$user->id);

		$title = trans('all.order').' #'.$order->inner_id.'('.$order->id.')';

        if($user->isClient()){
	        $performer = $order->getPerformerSender($user->id);
        } else {
	        $performer = $order->getPerformer($user->id);
        }

		if ($performer && $performer->transport_id !== null) {
			$transport =  Transport::findOrFail($performer->transport_id);
			
			$transportService = new TransportService($user);
			$transport = $transportService->transform($transport);
			$attached_trailer = $transport->getAttachTrailer();

			if($transport->drivers)
			{
				$driver = $transport->drivers->first();
			}

			if($attached_trailer->count() > 0)
				$trailer = $attached_trailer[0];
			else
				$trailer = null;

		} else {
			$transport = null;
			$trailer = null;
		}

		if($performer && $performer->user_id != $performer->sender_user_id) {
            $users['client'] = User::find($performer->sender_user_id);
			$users['client']->metaDataToArray();

//			logger('PDF CLIENT: '.$users['client']->id);
		} else
			$users['client'] = null;

		$driverInfo = null;
		$names = null; // TODO delete in future
		if (isset($driver)) {
//            strlen($driver->name) > 45 ? $driverInfo['name'] = str_split($driver->name, 45) : $driverInfo['name'] = $driver->name;
            $driverInfo['name'] = $driver->name;
            $driverInfo['phone'] = $driver->phone;
		}

		if($performer && $performer->user_id) {
			$users['owner'] = User::find($performer->user_id);
			if($users['owner']->islogist()){
				$users['owner'] = User::find($users['owner']->parent_id);
			}

//			logger('PDF CARGO: '.$users['owner']->id);
		} else
			$users['owner'] = null;

		$signatures = [];

		if(self::$document !== null){
			$sign = self::$document->graph_signature;
			$userId = $user->id;

			$filtered = $sign->filter(function ($value, $key) use ($userId) {
				return $value['user_id_added'] == $userId;
			});

			if($filtered->count() > 0){
				foreach ($filtered as $item){
					$signatures[$item->user_id_added] = $item;
				}
			}

		}

//		$filename_template = 'pdf.order'; // TODO temp

		$filename_template = template_filename(self::$templateSlug);

		if( !self::checkViewExists($filename_template))
			return false;

		$pdf = \App::make('dompdf.wrapper');

		$id = self::$templateId;

//		echo view('pdf.pdf_layout', compact('performer','filename_template','id','title', 'templateId', 'order', 'transport', 'trailer', 'users', 'driverInfo', 'user', 'signatures'))->render();

		$pdf->loadHTML(view('pdf.pdf_layout', compact('performer', 'filename_template','id','title', 'templateId', 'order', 'transport', 'trailer', 'users', 'names', 'user', 'signatures'))->render());

		if($filename){
			// delete old file
			DocumentService::destroyFile($filename);
			$pdf->save(public_path('storage/documents/').$filename);
			return true;
		}

		return $pdf->stream();
	}

	public static function create_OrderWaybill($order_id, $filename = false, $fake_sign = false){

		logger('PDF ORDER WAYBILL ID: '.$order_id);

		$order = Order::find($order_id);

		$templateId = self::$templateId;

		if(self::$userId){
			$user = User::findOrFail(self::$userId);
			logger('PDF CREATOR JOB: '.$user->id);
		} else {
			$user = auth()->user();
		}


//		logger('PDF CREATOR: '.$user->id);

		$title = trans('all.order').' #'.$order->inner_id.'('.$order->id.')';

		$performer = $order->getPerformer($user->id);

		if ($performer && $performer->transport_id !== null) {
			$transport =  Transport::findOrFail($performer->transport_id);

			$transportService = new TransportService($user);
			$transport = $transportService->transform($transport);
			$attached_trailer = $transport->getAttachTrailer();

			if($transport->drivers)
			{
				$driver = $transport->drivers->first();
			}

			if($attached_trailer->count() > 0)
				$trailer = $attached_trailer[0];
			else
				$trailer = null;

		} else {
			$transport = null;
			$trailer = null;
		}

		$driverInfo = null;
		$names = null; // TODO delete in future
		if (isset($driver)) {
//            strlen($driver->name) > 45 ? $driverInfo['name'] = str_split($driver->name, 45) : $driverInfo['name'] = $driver->name;
			$driverInfo['name'] = $driver->name;
			$driverInfo['phone'] = $driver->phone;
		}

		$signatures = [];

		if(self::$document !== null){
			$sign = self::$document->graph_signature;
			$userId = $user->id;

			$filtered = $sign->filter(function ($value, $key) use ($userId) {
				return $value['user_id_added'] == $userId;
			});

			if($filtered->count() > 0){
				foreach ($filtered as $item){
					$signatures[$item->user_id_added] = $item;
				}
			}
		}

		$signatures_roles = [];

		if(self::$document){
			$signmobilids = self::$document->mobileid;
			foreach ($signmobilids as $signmobilid) {
				if (!empty($signmobilid->cert_info))
					$signatures_roles[\App\Models\Role::getRoleNameById($signmobilid->role_id)] = json_decode($signmobilid->cert_info);
			}

//			$driver_role = \App\Enums\UserRoleEnums::DRIVER;
		}

//		dd($signatures);

		$filename_template = template_filename(self::$templateSlug);

		if( !self::checkViewExists($filename_template))
			return false;

		$pdf = \App::make('dompdf.wrapper');

		$id = self::$templateId;

//		echo view('pdf.pdf_layout', compact('performer', 'filename_template','id','title', 'templateId', 'order', 'transport', 'trailer', 'user'))->render();

		$types = [
			'individual'
		];

		$pdf->loadHTML(view('pdf.pdf_layout', compact('performer', 'filename_template','id','title', 'templateId', 'order', 'transport', 'trailer', 'user', 'fake_sign', 'signatures_roles'))->render());

		if($filename){
			// delete old file
			DocumentService::destroyFile($filename);
			$pdf->save(public_path('storage/documents/').$filename);
			return true;
		}

		return $pdf->stream();
	}

	private static function checkViewExists($filename_template){
		$pdf_view = 'pdf.templates.'.$filename_template;
		if (!view()->exists($pdf_view))
			return false;

		return true;
	}

	public static function document_template_preview($id, $filename_template){

		$title = trans('all.templates');

		if( !self::checkViewExists($filename_template))
			return redirect()->back();

		$user = auth()->user();

		$pdf = \App::make('dompdf.wrapper');

//		$pdf->loadHTML(view('pdf.pdf_layout', compact('performer', 'filename_template','id','title', 'templateId', 'order', 'transport', 'trailer', 'users', 'names', 'user', 'signatures'))->render());

//		echo view('pdf.pdf_layout', compact('filename_template','id','title', 'user'))->render();

		$pdf->loadHTML(view('pdf.pdf_layout', compact('filename_template','id','title', 'user'))->render());

		return $pdf->stream();
	}

    public static function import_pdf_document($pdf)
    {
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        return $pdf->stream();
    }

	/**
	 * Generate FileName from Template
	 *
	 * @param $template
	 * @param string $id
	 *
	 * @return string
	 */
    private static function generateFileName($template, $id = ''){
	    return template_filename($template->slug).'_'.time().'_'.$id.'_'.Str::random(10).'.'.strtolower($template->format);
    }

}