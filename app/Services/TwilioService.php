<?php

namespace App\Services;

use Twilio;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Mail\AdminSystemMsg;

class TwilioService extends BaseService
{
	public static function sendSMS($phone, $msg){

        if($phone === null){
            logger('Driver ERROR'.$msg.' has not phone');
            return false;
        }

        if(config('innlogist.twilio_send') === false){
			return true;
        }

		preg_replace('/(\+\d+)?\s*(\(\d+\))?([\s-]?\d+)+/', "", $phone);
		$phone = str_replace('(', '', $phone);
		$phone = str_replace(')', '', $phone);

		try {
			Twilio::message($phone, $msg);
//		} catch (\Services_Twilio_RestException $exception) {
		} catch (\Exception  $exception) {
			Log::info($exception->getMessage());
			Mail::to(config('innlogist.email_feedback'))->send(new AdminSystemMsg($exception->getMessage(), 'Twilio Error'));
			return false;
		}
		return true;

	}
}