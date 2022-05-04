<?php

namespace App\Http\Controllers;

use App\Cars;
use App\Models\Ccards;
use App\Documents;
use App\Models\Image;
use App\Models\Document\DocumentUser;
use App\Models\Order\Offer;
use App\Models\Transport\Transport;
use App\Models\Transport\TransportDriver;
use App\Models\RoleUser;
use App\Models\Specialization;
use App\Models\SpecializationUser;
use App\SpecializationUsersRel;
use App\Models\UserData;
use Illuminate\Http\Request;
use App\Helpers\Options;
use App\Models\User;
use App\Http\Controllers\UserDataController;
use App\Services\UserDataService;

use App\Models\PhoneActivations;
use App\Http\Controllers\TranslateDBController;
use App\Models\Status;
use App\Models\Role;
use Mail;
use App\Mail\AdminSubmit;
use Auth;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('Admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        return view('admin.home.index');
    }

    public static function users_list($request, $users)
    {

    }

    /**
     * Show users.
     *
     * @param Request $request
     * @param $roleName
     * @return mixed
     */
    public function usersRole(Request $request, $roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            $users = $role->users()->paginate(10);

            foreach($users as $user){
                $user->unserialize();
                $status = Status::find($user->status);
                if($status) {
                    $user->status = $status->name;
                }
            }

            return view('admin.users.index', compact('users'));
        }

        return abort(404, 'Role not found.');
    }

// Todo:delete
//    public function users_role(request $request, $role)
//    {
//        $paginate_count = Options::get('pagination_count');
//        $users = User::where('role_id', $role)->paginate($paginate_count);
//
//        $r = Roles::where('id', $role)->first();
//        if(count($r)==0)
//            return abort(404);
//
//        $options['title'] = trans('all.'.$r->name);
//
//        return view('admin.users.index')
//            ->with('users', $users);
//    }

    public function usersType(Request $request, $type)
    {
        $usersID = RoleUser::getUsersID( Role::getTypeID($type) );

        $users = User::whereIn('id', $usersID)->paginate(10);
        foreach($users as $user){
            $user->unserialize();
            $status = Status::find($user->status);
            if($status) {
                $user->status = $status->name;
            }
        }

        return view('admin.users.index', compact('users'));
    }


// Todo:delete
//    public function users_type(request $request, $type)
//    {
//        $roles = Roles::where('type', $type)->get();
//        $paginate_count = Options::get('pagination_count');
//        $roles_id = [];
//        foreach ($roles as $role) {
//            $roles_id[] = $role->id;
//        }
//        $users = User::where('role_id', 'IN', $roles_id)->paginate($paginate_count);
//
//        return view('admin.users.index')
//            ->with('users', $users);
//    }

    public function showUser(User $user)
    {
        $user->data = (new UserDataService)->all($user->id);
        $user->images = $user->images()->where('imagetable_type', User::class)->get();

        $is_verified = true;

        $user->ccards = $user->ccards()->get();
        foreach($user->ccards as $card) {
            $n = CcardController::decode($card->n);
            $number = @unserialize($n);
            if ($number === false)
                $number = $n;

            $card->lastFour = CcardController::mask_card_number($number);
        }

        $user->specializations = $user->specializations()->get();

        /*
        foreach($user->specializations as $specialization) {
            $specialization->info = Specialization::where('id', $specialization->ids)->first();
            dd($specialization->info);
        }
        */

        $user->documents = $user->documents()->get();
        foreach($user->documents as $document) {

            if($document->verified == 0)
                $is_verified = false;

            $document->images = Image::where('imagetable_type', Documents::class)
                ->where('imagetable_id', $document->id)->get();

            foreach($document->images as $image) {

                if($image->verified == 0)
                    $is_verified = false;

            }

        }

        $transports = ['trailer' => [], 'transport' => []];
        $user_transports = $user->transports()->get();
        foreach($user_transports as $user_transport) {


            if($user_transport->verified == 0)
                $is_verified = false;

            $user_transport->images = Image::where('imagetable_type', Transport::class)
                ->where('imagetable_id', $user_transport->id)->get();

            foreach($user_transport->images as $image) {
                if($image->verified == 0) $is_verified = false;
            }


            if($user_transport->isTrailer()) $key = 'trailer'; else $key = 'transport';
            $transports[$key][$user_transport->id] = $user_transport;
        }

        $required_files['images']       = ImageController::getRequiredImages($user->id);
        $required_files['documents']    = DocumentController::getRequiredDocuments($user->id);

        /*
        $staffs = $user->getStaffs();
        foreach($staffs as $staff){
            $user_transports = $staff->transports()->get();
            foreach($user_transports as $user_transport) {

                $user_transport->images = Image::where('imagetable_type', Transport::class)
                    ->where('imagetable_id', $user_transport->id)->get();

                if($user_transport->isTrailer()) $key = 'trailer'; else $key = 'transport';
                $transports[$key][$user_transport->id] = $user_transport;
            }
        }
        */
        /*
        if ($user->hasRole('logistic-person')) {
            $user->carDocument = $user->car->documents() ? $user->car->documents()->images : [];
            $user->trailerDocument = $user->car->trailerDocuments() ? $user->car->trailerDocuments()->images : [];
        }
        */
        return view('admin.users.view', compact('user', 'options', 'transports', 'required_files', 'is_verified'));
    }


    public function block($user_id){

        $user = User::find($user_id);

        if($user){
            if($user->verified == 0)
                $user->verified = 1;
            else
                $user->verified = 0;

            $user->save();

            $json = json_encode(['result' => true, 'msg' => 'ok', 'redirect' => route('admin.users.requests')]);
        } else {
            $json = json_encode(['result' => false, 'msg' => 'user not found', 'redirect' => route('admin.users
            .requests')]);
        }

        return $json;
    }

    public function delete($user_id){

        $user = User::find($user_id);

        if($user){

            $ccards = Ccards::where('user_id', $user_id)->get();
            foreach($ccards as $ccard)
                $ccard->delete();

            $documents = DocumentUser::where('user_id', $user_id)->get();
            foreach($documents as $document)
                $document->delete();

            $images = Image::where('user_id', $user_id)->get();
            foreach($images as $image)
                $image->delete();

            $offers = Offer::where('user_id', $user_id)->get();
            foreach($offers as $offer)
                $offer->delete();

            $activations = PhoneActivations::where('user_id', $user_id)->get();
            foreach($activations as $activation)
                $activation->delete();

            $roles = RoleUser::where('user_id', $user_id)->get();
            $path = $user->getRole();
            foreach($roles as $role) {
                $role->delete();
            }

            $specialization_users = SpecializationUser::where('user_id', $user_id)->get();
            foreach($specialization_users as $specialization_user)
                $specialization_user->delete();

            $transports_drivers = TransportDriver::where('user_id', $user_id)->get();
            foreach($transports_drivers as $transports_driver)
                $transports_driver->delete();

            $users_data = UserData::where('user_id', $user_id)->get();
            foreach($users_data as $item)
                $item->delete();

            $user->delete();
            $json = json_encode(['result' => true, 'msg' => 'ok', 'redirect' => route('admin.users.type', $path)]);
        } else {
            $json = json_encode(['result' => false, 'msg' => 'user not found', 'redirect' => route('admin.users
            .requests')]);
        }

        return $json;
    }

//    Todo:delete
//    public function view_user(request $request, $user_id)
//    {
//        $user = User::where('id', $user_id)->first();
//        if(count($user) == 0)
//            return abort(404);
//
//        $request_array = UserDataController::get_request_array();
//        $car_array = UserDataController::get_car_array();
//
//        $options = [];
//
//        foreach($request_array as $item)
//        {
//            $new_item = 'new_'.$item;
//            $new_request_array[] = $new_item;
//            $options[$new_item] = UserDataController::get($user->id, $new_item);
//            $options[$item] = UserDataController::get($user->id, $item);
//        }
//
//
//
//        foreach($car_array as $key => $item)
//        {
//            $new_item = '%new_car_%%_'.$item.'%';
//            $new_car_array[] = $new_item;
//            $user_data = UserData::where('user_id', $user->id)->where('name', 'LIKE', $new_item)->get();
//            foreach($user_data as $car_items)
//            {
//                $k = $car_items->name;
//                $options[$k] = $car_items->value;
//            }
//        }
//
//        if($user->phone==null)
//            $user->phone = UserDataController::get($user->id, 'phone_temp');
//        else
//            $user->phone_temp = false;
//
//        $options['social_link'] = Options::generate_social_link($user->social_type, $user->social_id);
//
//        $images['reg_docs'] = ImagesConroller::get_images_by_type($user->id, 'reg_docs');
//        $images['passport'] = ImagesConroller::get_images_by_type($user->id, 'passport');
//        $images['bank'] = ImagesConroller::get_images_by_type($user->id, 'bank');
//
//        $cars['old'] = CarsController::get_cars($user->id, null, 1);
//        $cars['new'] = CarsController::get_cars($user->id, null, 0);
//
//
//        foreach($cars as $type_key => $car_type)
//        {
//            foreach($car_type as $k => $car)
//            {
//                $images['cars'][$car->car_id]['transport_photo'] = ImagesConroller::get_user_car($user->id, $car->car_id, 'transport_photo');
//                $images['cars'][$car->car_id]['tp_photo'] = ImagesConroller::get_user_car($user->id, $car->car_id, 'tp_photo');
//            }
//        }
//
//        $options['sp'] = [];
//        $sp_new = UserDataController::get($user->id, 'new_sp');
//        if($sp_new==false)
//            $options['sp']['new'] = [];
//        else
//            $options['sp']['new'] = json_decode($sp_new);
//
//
//        $options['sp']['old'] = Specialization::get_user_specializations($user->id);
//
//        $options['sp_path']['new'] = Specialization::generate_paths_from_routes($options['sp']['new']);
//        $options['sp_path']['old'] = Specialization::generate_paths_from_routes($options['sp']['old']);
//
//
//        $options['documents_data']['new'] = DocumentController::get_documents($user->id, 0);
//        $options['documents_data']['old'] = DocumentController::get_documents($user->id, 1);
//
//        foreach($options['documents_data'] as $type_key => $doc_type)
//        {
//            foreach($doc_type as $k => $doc)
//            {
//                $doc->doc_info = Specialization::get_doc_by_route_id($doc->id);
//            }
//
//        }
//
//        return view('admin.users.view')
//            ->with('user', $user)
//            ->with('options', $options)
//            ->with('images', $images)
//            ->with('cars', $cars);
//
//    }

//    public function requests(request $request)
//    {
//        $users_ids = UserDataController::get_users_requsts();
//
//        $paginate_count = Options::get('pagination_count');
//
//        $users = User::whereIn('id', $users_ids)->paginate($paginate_count);
//        return view('admin.users.requests')
//            ->with('users', $users);
//    }


    public function update_user(request $request, $user_id)
    {
        $result = $request->get('a');
        $user = User::where('id', $user_id)->first();
        $user->metaDataToArray();
        $path = $user->getRole();

        $request_array = UserDataController::get_request_array();
        $user_transports = $user->transports()->get();
        $docs_array = UserDataController::get_docs_array();

        $options = [];
        $data = $user->meta_data;

        foreach ($request_array as $item) {
            $new_item = 'new_' . $item;
            $new_request_array[] = $new_item;
            $data[$item] = (new UserDataService)->get($user->id, $new_item);
            if ($data[$item] == false) {
                if(isset($user->meta_data[$item])) {
                    $data[$item] = $user->meta_data[$item];
                }
            }

	        (new UserDataService)->remove($user->id, $new_item);
        }

        if ($result == 1) {
	        (new UserDataService)->remove($user->id, 'request_rejected');
        } else {
	        (new UserDataService)->set($user->id, 'request_rejected', 'true');
            $json = json_encode(['result' => true, 'msg' => 'ok', 'redirect' => route('admin.users.type', $path)]);
            return $json;
        }


        $status = Status::where('type', 'user')
            ->where('name', 'Accepted')->first();
        $data['status'] = 1;

        $user->update(['meta_data' => json_encode($data)]);

        foreach($user_transports as $user_transport) {
            $user_transport->update(['verified' => true]);
        }


        $user->images = $user->images()->where('imagetable_type', User::class)->get();

        foreach($user->images as $img) {
            $img->update(['verified' => true]);
        }

        $user->documents = $user->documents()->get();
        foreach($user->documents as $document) {

            $document->update(['verified' => true]);
            $document->images = Image::where('imagetable_type', Documents::class)->where('imagetable_id', $document->id)->get();
            foreach($document->images as $img){
                $img->update(['verified' => true]);
            }
        }

        $specializations = SpecializationUser::where('user_id', $user->id)->get();
        foreach($specializations as $specialization) {
            $specialization->update(['accepted' => true]);
        }

        /*
        $cars = CarsController::get_cars($user->id);

        if (count($cars) > 0) {
            foreach ($cars as $car) {
                $car->accepted = 1;
                $car->save();
            }
        }


        $options['sp'] = json_decode(UserDataController::get($user->id, 'new_sp'));

        $old_sp = SpecializationUsersRel::where('user_id', $user->id)->get();
        foreach ($old_sp as $sp) {
            $sp->delete();
        }


        if ($options['sp'] != null) {
            foreach ($options['sp'] as $sp_item) {
                $sp_user = new SpecializationUsersRel();
                $sp_user->user_id = $user->id;
                $sp_user->route_id = $sp_item;
                $sp_user->save();
            }
        }

        $old_docs = Documents::where('user_id', $user->id)->get();
        foreach ($old_docs as $doc) {
            $doc->accepted = 1;
            $doc->save();
        }

        foreach ($docs_array as $key => $item_doc) {
            $new_item_doc = '%new_' . $item_doc . '%';
            $info_docs = UserData::where('user_id', $user->id)->where('name', 'LIKE', $new_item_doc)->get();
            foreach ($info_docs as $doc_items) {
                $doc_items->delete();
            }
        }

        */

        $admin = Auth::guard("admin_users")->user();
        Mail::to($user->email)->send(new AdminSubmit($user, $admin));


        $json = json_encode(['result' => true, 'msg' => 'ok', 'redirect' => route('admin.users.type', $path)]);
        return $json;

    }

}