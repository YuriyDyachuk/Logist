<?php

namespace App\Services;

use App\Models\Signature;
use App\Models\SignatureStatus;
use App\Models\Role;

use Illuminate\Support\Str;
use App\Jobs\ProcessSignatureStatus;
use Carbon\Carbon;
use App\Services\GcmService;
use App\Services\PDFService;

use App\Enums\UserRoleEnums;

class MobileIdService {

	private $provider;
	private $transid;
	private $password;
	private $datetimeUTC;
	private $dataSigned;
	private $dataDisplayed;
	private $file;

	private function fileNameForOrigin($filename) {
		return substr($filename, 0, strpos($filename, '.')) . '_origin.' . substr($filename, strpos($filename, '.') + 1);
	}

    /**
     * @param      $user
     * @param      $document
     * @param null $phone
     * @return bool
     */
	public function sendNew($user, $document, $phone = null, $role_id = null){
		//make origin file for sign
		$origin_filename = $this->fileNameForOrigin($document->filename);
		if(!file_exists(public_path() .'/storage/documents/' . $origin_filename)) {
			copy(public_path() .'/storage/documents/' . $document->filename, public_path() .'/storage/documents/' . $origin_filename);
		}

		$filehash = hash_file( 'sha256', public_path() .'/storage/documents/' . $origin_filename, TRUE);
		$filehash_base64 = base64_encode($filehash);

		$transaction = Str::random(31);

		$data = [
			'user_id'           => $user->id,
			'role_id'           => $role_id,
			'phone'             => $phone ? $phone : $user->phone,
			'transaction_id'    => $transaction,
			'document_id'       => $document->id,
			'filehash'          => $filehash_base64
		];

		$signature = Signature::create($data); 

		innlogger_sign(print_r($data,1));

		$is_test = config('innlogist.signature_test') ? 'test_' : '';

		$content_sent = file_get_contents(storage_path().'/mobileid/'.$is_test.'new.xml');

		//provider && password
		$content_sent = $this->setAuthData($content_sent);

		//transid
		$content_sent = $this->setTransactionId($content_sent, $transaction);

		//datetime
		$content_sent = $this->setDate($content_sent);

		//dataSigned
		$content_sent = str_replace('[[dataSigned]]', $filehash_base64, $content_sent);

		//dataDisplayed
//		$content_sent = str_replace('[[dataDisplayed]]', 'Neobhidno pidtverdyty vashi dani', $content_sent);
		$content_sent = str_replace('[[dataDisplayed]]', 'Подписать документ', $content_sent);

        //phone
        $content_sent = str_replace('[[phone]]', $data['phone'], $content_sent);

        innlogger_sign('sendNew Request :');
        innlogger_sign(print_r($content_sent,1));

		$server_status = $this->curl($content_sent);

        innlogger_sign('sendNew Response :');
        innlogger_sign(print_r($server_status,1));

		$parsed= $this->parse($server_status);

		$transaction_id = null;
		$mssp_transaction_id = '';

		//Parse XML
		foreach ($parsed as $key => $val){
			if(strtoupper ($val['tag']) == 'MSS_SIGNATURERESP' && isset($val['attributes'])){
				$mssp_transaction_id = $val['attributes']['MSSP_TRANSID'];
			}

			if(strtoupper ($val['tag']) == 'FAULTSTRING'){
				return array($val['value']);
			}
		}

		if($mssp_transaction_id == ''){
			innlogger_sign('Error mssp_transaction_id :'.$signature->id);
			return false;
		}

		if($signature){
			$signature->update(['mssp_transaction_id' => ltrim($mssp_transaction_id, '_')]);
			$this->setJob($signature->id);
			return $signature->id;
		}

		return false;
	}

	private function parse($content){
		$xml = simplexml_load_string($content);
		$p = xml_parser_create();
		xml_parse_into_struct($p, $content, $vals, $index);
		xml_parser_free($p);

		return $vals;
	}

	public function checkStatus($signature_id, $attempt, $time = false){

		$time_now = Carbon::now();

		innlogger_sign('Status Check: '.$signature_id);

		$totalDuration = $time !== false ?$time_now->diffInSeconds($time) : 0;

		if(config('innlogist.signature_check_max_attempt') == $attempt){
			return ['status' => 'limit'];
		}

		innlogger_sign('Total Duration: '.$totalDuration);
		innlogger_sign('Attempt: '.$attempt);

		// second request delay
		if($attempt == 2 && $totalDuration < config('innlogist.signature_check_second')){
			$this->setJob($signature_id, $attempt++, config('innlogist.signature_check_second'));
			innlogger_sign('Limit 1--------------------');
			return ['status' => 'later'];
		}

		// other request delay
		if($attempt > 2 && $totalDuration < config('innlogist.signature_check_other')){
			$this->setJob($signature_id, $attempt++, config('innlogist.signature_check_other'));
			innlogger_sign('Limit 2---------------------');
			return ['status' => 'later'];
		}

		// get template
		$is_test = config('innlogist.signature_test') ? 'test_' : '';
		$content_sent = file_get_contents(storage_path().'/mobileid/'.$is_test.'status.xml');

		$signature = Signature::findOrFail($signature_id);

		//provider && password
		$content_sent = $this->setAuthData($content_sent);

		//mssp transid
		$content_sent = $this->setMsspTransactionId($content_sent, $signature->mssp_transaction_id);

		//transid
		$content_sent = $this->setTransactionId($content_sent, $signature->transaction_id);

		//datetime
		$content_sent = $this->setDate($content_sent);

        innlogger_sign('checkStatus Request :');
        innlogger_sign(print_r($content_sent,1));

		$response = $this->curl($content_sent,2);

        innlogger_sign('checkStatus Response :');
        innlogger_sign(print_r($response,1));

		$parsed = $this->parse($response);

		$status_code = 0;
		$status = true;
		$base64Signature = null;

		//Parse XML
		foreach ($parsed as $key => $val){
			if(strtoupper ($val['tag']) == 'NS5:STATUSCODE' && isset($val['attributes'])){
				// response from status request
				innlogger_sign(print_r($val, 1));
				$status_code = $val['attributes']['VALUE'];
			}

			if(strtoupper ($val['tag']) == 'NS4:BASE64SIGNATURE'){
				// response from status request
				innlogger_sign(print_r($val, 1));
				$base64Signature = $val['value'];
			}

			if(strtoupper ($val['tag']) == 'NS4:STATUSCODE' && isset($val['attributes'])){
				// response from first request
				innlogger_sign(print_r($val, 1));
				$status_code = $val['attributes']['VALUE'];
			}

			if(strtoupper ($val['tag']) == 'FAULTSTRING'){
				innlogger_sign(print_r($val, 1));
				$status = false;
				$status_code = $val['value'];
			}
		}

		$data = [
			'signature_id' => $signature->id,
			'transaction_id' => $signature->transaction_id,
			'mssp_transaction_id' => $signature->mssp_transaction_id,
			'status' => $status_code,
		];

		SignatureStatus::create($data);

		// set next request STATUS 504
		if($status_code == 504){

			if($attempt == 1) $delay = config('innlogist.signature_check_first');
			else if($attempt == 2) $delay = config('innlogist.signature_check_second');
			else $delay = config('innlogist.signature_check_other');

			$attempt++;

			$this->setJob($signature_id, $attempt, $delay);
			$signature->update(['status' => $status_code]);
			innlogger_sign('Status 504. Attempt: '.$attempt);
		}

		// get sign from request STATUS 502 or 500
		if($status_code == 502 || $status_code == 500){
			$cert_info = self::getCertInfo1($signature->id, $base64Signature);
			innlogger_sign('Signature info: '.json_encode($cert_info)); 
			$signature->update(['status' => $status_code, 'signature' => $base64Signature, 'cert_info' => $cert_info ? json_encode($cert_info) : '']);
			
			PDFService::storeDocumentToFile(0, \App\Enums\DocumentTypes::WAYBILL, $signature->user_id, $signature->document_id);
			
			$msg = GcmService::buildMessage('signature completed', 'signature');
			GcmService::sendNotification($signature->user_id, $msg);
		}

		return ['status' => $status, 'code' => $status_code];
	}

	public function getCertInfo_pars($sign_id, $base64Signature) {
		innlogger_sign('Signature decode: start decode'); // TODO test
		innlogger_sign('Signature decode: try to make dir'); // TODO test
		$path = public_path() . '/storage/sign_work';
		if(!file_exists($path)){
			mkdir($path, 0775, true);
		}
		$path = $path . '/';
        $infilename = $path . $sign_id . "_p.p7s";  // в этом файле зашифрованное сообщение
        $outfilename = $path . $sign_id . "_p.p7s.parsed";  // в этом файле распарсеные данные
		try {
			$str = base64_decode($base64Signature);
	
			file_put_contents($infilename, $str);
			$result = exec('openssl asn1parse -inform DER -in ' . $infilename . ' > ' . $outfilename);
			
			$str = file_get_contents($outfilename);
			$lines = explode("\n",$str);
			if (count($lines) < 10) return false;
			$key = '';
			$data = [];
			$stringKeys = [];
			$stringVals = [];
			$start_block = false;
			$this_block = false;
			foreach ($lines as $line ) {
				if (strpos($line, 'cons:') === false) 
				{
					if (strpos($line, 'prim: OBJECT') !== false ) {
						if ($key != '' && $start_block) {
							$stringKeys[] = $key;
							$val = '';
							if (count($data) > 0) {
								$val = (count($data) > 1 ? $data : trim($data[0]));
							} 
							$stringVals[] = $val;
							if ($key == 'X509v3 Certificate Policies' && (empty($val) || !is_array($val))) {
								$this_block = true;
							}
							$key = '';
							$data = [];
						}
						$line = substr($line, strpos($line, 'prim: OBJECT') + 12);
						$key = trim(substr($line, strpos($line, ':') + 1));
						if ($key == 'ecdsa-with-SHA256' || $key == '1.2.840.10045.4.3.2') {
							$start_block = !$start_block;
							if (!$start_block && !$this_block) {
								$stringKeys = [];
								$stringVals = [];
							}
							if (!$start_block && $this_block) {
								break;
							}
						} else {
							if (in_array($key, $stringKeys)) {
								$key = $key . '_1';
							}
						}
					} else {
						$line = substr($line, strpos($line, 'prim: ') + 6);
						$data[] = substr($line, strpos($line, ':') + 1);
					}
				}
			}
			unset($infilename);
			unset($outfilename);
			return (count($stringKeys) < 10 || count($stringVals) < 10 ? false : array_combine($stringKeys, $stringVals));
		} catch (Exception $e) {
			return false;
		}
	}

	public static function getCertInfo1($sign_id, $base64Signature) {
		innlogger_sign('Signature decode: start decode'); // TODO test
		innlogger_sign('Signature decode: try to make dir'); // TODO test
		$path = public_path() . '/storage/sign_work';
		if(!file_exists($path)){
			mkdir($path, 0775, true);
		}
		$path = $path . '/';
        $infilename = $path . $sign_id . "_p.p7s";  // в этом файле зашифрованное сообщение
        $outfilename = $path . $sign_id . "_p.p7s.parsed";  // в этом файле распарсеные данные
		try {
			$str = base64_decode($base64Signature);
	
			file_put_contents($infilename, $str);
			$result = exec('openssl asn1parse -inform DER -in ' . $infilename . ' > ' . $outfilename);
			
			$str = file_get_contents($outfilename);
			$lines = explode("\n",$str);
			if (count($lines) < 10) return false;
			$key = '';
			$data = [];
			$stringKeys = [];
			$stringVals = [];
			$start_block = false;
			$this_block = false;
			foreach ($lines as $line ) {
				if (strpos($line, 'cons:') === false) 
				{
					if (strpos($line, 'prim: OBJECT') !== false ) {
						if ($key != '' && $start_block) {
							$stringKeys[] = $key;
							$val = '';
							if (count($data) > 0) {
								$val = (count($data) > 1 ? $data : trim($data[0]));
							} 
							$stringVals[] = $val;
							if ($key == 'X509v3 Certificate Policies' && (empty($val) || !is_array($val))) {
								$this_block = true;
							}
							$key = '';
							$data = [];
						}
						$line = substr($line, strpos($line, 'prim: OBJECT') + 12);
						$key = trim(substr($line, strpos($line, ':') + 1));
						if ($key == 'ecdsa-with-SHA256' || $key == '1.2.840.10045.4.3.2') {
							$start_block = !$start_block;
							if (!$start_block && !$this_block) {
								$stringKeys = [];
								$stringVals = [];
							}
							if (!$start_block && $this_block) {
								break;
							}
						} else {
							if (in_array($key, $stringKeys)) {
								$key = $key . '_1';
							}
						}
					} else {
						$line = substr($line, strpos($line, 'prim: ') + 6);
						$data[] = substr($line, strpos($line, ':') + 1);
					}
				}
			}
			unset($infilename);
			unset($outfilename);
			return (count($stringKeys) < 10 || count($stringVals) < 10 ? false : array_combine($stringKeys, $stringVals));
		} catch (Exception $e) {
			return false;
		}
	}

	private function curl($data, $type = 1){

		// get sign or get status
		$request = ($type == 1) ? 'MSS_Signature' : 'MSS_StatusPort';

		$url = config('innlogist.signature_ip').'/MSSP/services/'.$request;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: text/xml; charset=utf-8',
			'SOAPAction:/opt/valimo'
		));
		//curl_setopt($ch, CURLOPT_SAFE_UPLOAD, TRUE);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$server_output = curl_exec($ch);

		if (curl_errno($ch)) {
			innlogger_sign('CURL Error: '.curl_error($ch));
		}

		curl_close($ch);
		return $server_output;
	}

	private function setAuthData($content){
		//provider
		$content = str_replace('[[provider]]', config('innlogist.signature_provider'), $content);

		//password
		$content = str_replace('[[password]]', config('innlogist.signature_password'), $content);

		return $content;
	}

	private function setJob($signature_id, $attempt = 1, $delay = false){
		if($delay !== false){
			ProcessSignatureStatus::dispatch($signature_id, $attempt)->delay(now()->addSeconds($delay));
		} else {
			ProcessSignatureStatus::dispatch($signature_id, $attempt);
		}

	}

	private function setDate($content){
		//datetime
		$datetimeUTC =  date("Y-m-d\TH:i:s.000\Z", strtotime("now"));
		return str_replace('[[datetime]]', $datetimeUTC, $content);
	}

	private function setTransactionId($content, $transaction){
		//transid
		return str_replace('[[transid]]', '_'.$transaction, $content);
	}

	private function setMsspTransactionId($content, $transaction){
		//mssp transid
		return str_replace('[[mssptransid]]', '_'.$transaction, $content);
	}

	private function pushToPhone($signature_id, $status){

	}

	public function isSignedMobileId($document_id, $template_id = null, $user = null){

		$data = [
			'status' => false,
			'phones_signed' => [],
			'users_signed' => [],
			'phones_unsigned' => [],
			'users_unsigned' => [],
			'loader_sign_status' => false,
			'receiver_sign_status' => false,
		];

		if($template_id == \App\Enums\DocumentTypes::WAYBILL){

			$role_driver_id = Role::getRoleIdByName(UserRoleEnums::DRIVER);
			$role_cargo_loader_id = Role::getRoleIdByName(UserRoleEnums::CARGO_LOADER);
			$role_cargo_receiver_id = Role::getRoleIdByName(UserRoleEnums::CARGO_RECEIVER);

			$result = Signature::where('document_id', $document_id)->whereIn('role_id', [$role_driver_id, $role_cargo_loader_id, $role_cargo_receiver_id])->whereNotNull('signature')->get();
			$result->makeHidden(['mssp_transaction_id' , 'transaction_id', 'signature']);

//			dump($result->toArray());

			$data['loader_sign_users'] = [
				[
					'role_id'   => $role_driver_id,
					'role_name' => UserRoleEnums::DRIVER,
					'sign'      => $result->contains('role_id', $role_driver_id),
				],
				[
					'role_id'   => $role_cargo_loader_id,
					'role_name' => UserRoleEnums::CARGO_LOADER,
					'sign'      => $result->contains('role_id', $role_cargo_loader_id),
				],
			];

			$data['receiver_sign_users'] = [
				[
					'role_id'   => $role_cargo_receiver_id,
					'role_name' => UserRoleEnums::CARGO_RECEIVER,
					'sign'      => $result->contains('role_id', $role_cargo_receiver_id),
				],
			];

			if($data['loader_sign_users'][0]['sign'] === true &&
			   $data['loader_sign_users'][1]['sign'] === true){
				$data['loader_sign_status'] = true;
			}

			if($data['receiver_sign_users'][0]['sign'] === true){
				$data['receiver_sign_status'] = true;
			}

			if($data['loader_sign_users'][0]['sign'] === true &&
			   $data['loader_sign_users'][1]['sign'] === true &&
			   $data['receiver_sign_users'][0]['sign'] === true){
				$data['status'] = true;
			}
		}

		$result = Signature::where('document_id', $document_id)->get();
		$result->makeHidden(['mssp_transaction_id' , 'transaction_id', 'signature']);

		if($result->isEmpty()){
			return $data;
		}

		$signed = $result->filter(function ($value, $key) {
			return $value->signature !== null;
		});

		$signed_no = $result->filter(function ($value, $key) {
			return $value->signature === null;
		});

//		if($result->count() == $signed->count()){
//			$data['status'] = $result->count() == 1 ? false : true;
			$data['phones_signed'] = $signed->pluck('phone');
			$data['users_signed'] = $signed->unique('user_id')->pluck('user_id');
			$data['phones_unsigned'] = $signed_no->pluck('phone');
			$data['users_unsigned'] = $signed_no->unique('user_id')->pluck('user_id');
//		}

//		if($signed_no->count() > 0){
//			$data['status'] = false;
//			$data['phones_signed'] = $signed->pluck('phone');
//			$data['phones_unsigned'] = $signed_no->pluck('phone');
//			$data['users_signed'] = $signed->pluck('user_id');
//			$data['users_unsigned'] = $signed_no->pluck('user_id');
//		}

//		$data['phones'] = $filtered->pluck('phone');

		return $data;
	}

	public function getSignInfo($document_id, $role_id){
		$result = Signature::where('document_id', $document_id)->where('role_id', $role_id)->whereNotNull('signature')->first();
		$signature = base64_decode($result->signature);

//		print_r($result->signature);
//		dd($signature);

		return true;
	}
}