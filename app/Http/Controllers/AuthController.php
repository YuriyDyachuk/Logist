<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailActivation;
use Mail;
use App\Models\User;
use Auth;
//use App\Mail\ActivationLink;

use App\Services\UserDataService;

class AuthController extends Controller
{
//    public static function activateUser($token)
//    {
//        $data = EmailActivation::where('token', $token);
//        if ($data->count() == 0) {
//            return false;
//        }
//
//        $activation = $data->first();
//        $user = User::find($activation->user_id);
//        $user->is_activated = true;
//        $user->save();
//        $activation->delete();
//        return $user;
//    }

//    public static function send_activation_mail($user, $token, $title)
//    {
//        Mail::to($user->email)->send(new ActivationLink($user, $token));
//    }


    public static function send_password_confirm_mail($user, $token, $title)
    {
        Mail::send(['html' => 'emails.password'], ['token' => $token, 'title'=>$title], function ($m) use ($user) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->to($user->email, $user->name)->subject(env('APP_NAME').' - '.trans('all.activation_mail'));
        });
    }

    public function password_accept($token, Request $request)
    {
        $user = Auth::user();
        $result = (new UserDataService)->get($user->id, 'new_password');

        if ($result != false) {
            if ($user->remember_token == $token) {
                $user->password = $result;
                $user->save();

	            (new UserDataService)->remove($user->id, 'new_password');

                $request->session()->flash('msg-success', trans('all.password_reseted'));
            } else {
                $request->session()->flash('msg-danger', trans('all.confirmation_token_is_wrong'));
            }
        } else {
            $request->session()->flash('msg-danger', trans('all.confirmation_notfound'));
        }
        return redirect()->route('orders');
    }


    public function reactivate_email(Request $request)
    {
        $user = Auth::user();
        $data = EmailActivation::where('user_id', $user->id);
        if($data->count() > 0)
        {
            $activation = $data->first();
            $token = $activation->token;
            $title = env('APP_NAME') . ' - ' . trans('all.activation_mail');
            AuthController::send_activation_mail($user, $token, $title);
            $json = ['result' => true, 'msg' => trans('all.message_resended')];
        }
        else
        {
            $json = ['result' => false, 'msg' => trans('all.you_already_activate_email')];
        }
        return $json;
    }
}
