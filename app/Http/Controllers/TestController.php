<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PDFService;
use App\Enums\DocumentTypes;
use App\Jobs\ProcessPdf;
use App\Services\MobileIdService;

class TestController extends Controller
{
	private $order_id;
	private $user_id;

	public function __construct() {
		$this->order_id = 986;
		$this->user_id = 81;
	}

	public function index(Request $request, $order_id, $user_id){
		if($order_id && $user_id){
			$this->order_id = $order_id;
			$this->user_id = $user_id;
		}

//		Test Request PDF
		PDFService::storeDocumentToFile($this->order_id, DocumentTypes::REQUEST, $this->user_id/*, 1013*/);


//		Test WayBill PDF
		//PDFService::storeDocumentToFile($this->order_id, DocumentTypes::WAYBILL, $this->user_id);
		$strbase='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';
		MobileIdService::getCertInfo1($this->order_id, $strbase);
//		dispatch(new ProcessPdf($this->order_id, $this->user_id, DocumentTypes::REQUEST));
	}
}
