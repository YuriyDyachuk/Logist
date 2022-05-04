<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio;
use App\Models\PhoneActivations;
use Auth;
use App\Models\User;

class PhoneController extends Controller
{

    public static function sendSMS($phone, $msg)
    {
        Twilio::message($phone, $msg);
        return true;
    }

    public static function is_user_can_send_activation($user_id)
    {
        $time = time();
        $min_time_mk = $time-3600;
        $min_time = date("Y-m-d H:i:s", $min_time_mk);
        $data = PhoneActivations::where('user_id', $user_id)
        ->where('created_at', ">=", $min_time);
        if($data->count()>=3)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function send_activation_sms_ajax(Request $request)
    {
        $user = Auth::user();
        $phone = $request->get('phone');
        $phone = str_replace(' ','',$phone);
        $result = SELF::send_sms_activation($user->id, $phone);
        if($result==1)
            $json = ['result' => true, 'msg' => 'ok'];
        if($result==-1)
            $json = ['result' => false, 'msg' => trans('validation.phone_unique')];
        if($result==-2)
            $json = ['result' => false, 'msg' => trans('validation.code_limit')];


        return response()->json($json);
    }

    public function check_code_sms_ajax(Request $request)
    {
        $user = Auth::user();
        $phone = $request->get('phone');
        $phone = str_replace(' ','',$phone);
        $code = $request->get('code');
        $data = PhoneActivations::where('user_id', $user->id)
            ->where('phone', $phone)
            ->orderBy('created_at', 'desc')
            ->first();
        if($data->code == $code)
        {
            $data->verified = 1;
            $data->save();

            $user->phone = $phone;
            $user->save();

            $json = json_encode(['result' => true, 'msg' => 'ok']);
        }
        else
        {
            $json = json_encode(['result' => false, 'msg' => trans('validation.code_wrong')]);
        }

        return $json;
    }

    public static function send_sms_activation($user_id, $phone)
    {
        $user = User::where('id', $user_id)->first();
        $phone = str_replace(' ','',$phone);

        $count = User::where('phone', $phone)->where('id', '!=', $user->id)->count();
        if($count>0)
        {
            return -1;
        }

        $can_send_msg = SELF::is_user_can_send_activation($user->id);
        if($can_send_msg)
        {
            $sms_message = trans('all.sms_activation');
            $code = rand(111111, 999999);
            $msg = str_replace('%code%', $code, $sms_message);

            $phone_activation = new PhoneActivations();
            $phone_activation->phone = $phone;
            $phone_activation->code = $code;
            $phone_activation->verified = 0;
            $phone_activation->user_id = $user->id;
            $phone_activation->save();

            SELF::sendSMS($phone, $msg);
            return 1;
        }
        else
        {
            return -2;
        }
    }



}
