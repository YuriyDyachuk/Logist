<?php

namespace App\Http\Controllers;

use App\Cars;
use App\Models\Ccards;
use App\Models\EmailActivation;
use Illuminate\Http\Request;
use App\Models\UserData;
use Auth;
use App\Models\User;
use DB;
use Mail;
use App\Mail\RegisteredUser;

use App\Services\UserDataService;


class UserDataController extends Controller
{

	private $user_data_service;


	public function __construct(UserDataService $user_data_service) {
		$this->user_data_service = $user_data_service;
	}

	/**
     * Update Or Create user data
     *
     * @param $userID
     * @param $name
     * @param $value
     *
     */
    public function set($userID, $name, $value)
    {

    	$response = $this->user_data_service->set($userID, $name, $value);

	    if (\Illuminate\Support\Facades\Request::ajax()) {
	    	return response()->json($response);
	    }

    	return $response;
    }

    public function remove($user_id, $name)
    {
	    $response = $this->user_data_service->remove($user_id, $name);
	    if (\Illuminate\Support\Facades\Request::ajax()) {
		    return response()->json($response);
	    }

	    return $response;
    }

    public function get($user_id, $name)
    {
	    $response = $this->user_data_service->get($user_id, $name);

	    if (\Illuminate\Support\Facades\Request::ajax()) {
		    return response()->json($response);
	    }

	    return $response;
    }

    public function all($user_id)
    {
	    $response = $this->user_data_service->all($user_id);

	    if (\Illuminate\Support\Facades\Request::ajax()) {
		    return response()->json($response);
	    }

	    return $response;
    }

//    public static function getToken()
//    {
//        return hash_hmac('sha256', str_random(40), config('app.key'));
//    }

//    public static function get_role($role_id)
//    {
//        $role = Roles::where('id', $role_id)->first();
//        return $role;
//    }


//    public static function get_cars_list($user_id)
//    {
//        $cars = Cars::where('user_id', $user_id)->get();
//        return $cars;
//    }


//    public static function is_activated_email($user_id)
//    {
//        $data = EmailActivation::where('user_id', $user_id);
//        if($data->count()>0)
//            return false;
//        else
//            return true;
//    }
//
//
//    public static function is_activated_user($user_id)
//    {
//        $active_email = SELF::is_activated_email($user_id);
//        $user = User::where('id', $user_id)->first();
//        $active_phone = false;
//        if($user->phone != null)
//            $active_phone = true;
//        if($active_email && $active_phone)
//            return true;
//        else
//            return false;
//
//    }
//
//    public static function get_request_array()
//    {
//        return [
//            'egrpou_or_inn',
//            'company_name',
//            'sp',
//            'name',
//            'sp_description',
//            'photos_reg_docs',
//            'photos_passport',
//            'photos_bank',
//            'city',
//            'region',
//            'country',
//            'legal_address',
//            'index',
//            'company_description',
//            'site_url',
//            'company_logo'
//        ];
//    }
//
//    public static function get_car_array()
//    {
//        return ['transport_photo_photo', 'tp_photo_photo', 'info_model', 'info_color', 'info_number'];
//    }
//
//    public static function get_docs_array()
//    {
//        return ['docs_'];
//    }
//
//    public static function get_users_requsts()
//    {
//        $request_array = SELF::get_request_array();
//        $car_array = SELF::get_car_array();
//        $docs_array = SELF::get_docs_array();
//
//        $user_ids = [];
//        $new_car_array = [];
//        $new_request_array = [];
//
//        foreach($request_array as $key => $item)
//        {
//
//            $new_item = 'new_'.$item;
//            $new_request_array[] = $new_item;
//            if($key==0)
//                $user_data = UserData::orWhere('name', $new_item);
//            else
//                $user_data = $user_data->orWhere('name', $new_item);
//        }
//
//
//
//        foreach($car_array as $key => $item)
//        {
//            $new_item = '%new_car_%%_'.$item.'%';
//            $new_car_array[] = $new_item;
//            $user_data = $user_data->orWhere('name', 'LIKE', $new_item);
//        }
//
//        foreach($docs_array as $key => $item_doc)
//        {
//            $new_item_doc = '%new_'.$item_doc.'%';
//            $user_data = $user_data->orWhere('name', 'LIKE', $new_item_doc);
//        }
//
//        $u = $user_data->distinct()->get(['user_id']);
//
//        foreach($u as $item)
//        {
//            $user_ids[] = $item->user_id;
//        }
//
//        return $user_ids;
//    }

}
