<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAddUser;
use App\Http\Requests\StoreAddService;

use App\Enums\UserRoleEnums;

use App\Models\User;
use App\Models\Role;
//use App\Models\RoleUser;
use App\Models\UserData;
use App\Models\Document\Document;
//use App\Models\EmailActivation;
//use App\Models\PhoneActivations;
use App\Services\VerificationService;
use App\Services\TwilioService;
use App\Services\SubscriptionService;
use App\Services\AmplitudeService;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhoneController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Auth\Events\Registered;

use Illuminate\Foundation\Auth\RegistersUsers;
use GuzzleHttp\Psr7\Response;
use Carbon\Carbon;


use Mail;
use App\Mail\ActivationLink;
use App\Mail\RegisteredUser;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = '/orders';
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(Request $request){
		$this->create_pre_order_params($request);

        return view('auth.register');
    }

	/**
	 * Update creating order from landing
	 *
	 * @param $request
	 */
    private function create_pre_order_params($request){
	    $request->session()->forget('pre_order_addresses');
	    if($request->has('from') && $request->has('from_place_id') && $request->has('to') && $request->has('to_place_id')){
		    session(['pre_order_addresses' => $request->except('_token')]);
	    }

	    $request->session()->forget('pre_order_cargo');
	    if($request->has('pre_order_cargo')){
		    session(['pre_order_cargo' => $request->except('_token')]);
	    }
    }

    /**
     * Show a new user form
     *
     * @param  array $data
     * @return User
     */
    public function show($account)
    {

		if($account == 'client')
		    $amplitude = ['type_carrier' => true];

	    if($account == 'logistic')
		    $amplitude = ['type_cargo_owner' => true];

	    (new AmplitudeService())->request('Choose role type', $amplitude);

        return view('auth.profile-register', ['account' => $account]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function create($request)
    {

        $user           = User::firstOrNew(['email' => $request->email]);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->invited  = false;

        // Role
        $role_request = explode('-', $request->role);

	    $role_id = 2; // client - default

        if(is_array($role_request)){
            $role = $role_request[0];
            $role_id_t = Role::getRoleIdByName($role);

            if($role_id_t !== false)
	            $role_id = $role_id_t;
        }

        // START pre-order from landing
	    if(session('pre_order_addresses')){
		    $user->meta_data = ['pre_order_addresses' => session('pre_order_addresses')];
	    }

	    if(session('pre_order_cargo')){
		    $user->meta_data =  session('pre_order_cargo');
	    }

	    // END pre-order from landing

        $user->save();
        $user->roles()->sync($role_id);

        $verification = new VerificationService();
        $verification_token = $verification->create($user, $user->email);
        $this->sendActivationMail($user, $verification_token['token'], $request);

//        $this->addDefaultDocuments($user);

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  StoreAddUser $request
     * @return \Illuminate\Http\Response
     */
    public function register(StoreAddUser $request)
    {
        event(new Registered($user = $this->create($request)));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function registerPhone(Request $request){
        $userId = $request->session()->get('register_phone_user');

        if(!$request->session()->has('register_phone_user')){
            return redirect('/');
        }

        return view('auth.register_phone', compact('userId'));
    }

    public function registerSend($type, Request $request){
        $verification = new VerificationService();

	    if($type == 'phone'){

		    $request->phone = str_replace('-', '', $request->phone);

		    $request->request->add(['phone' => $request->phone]);

		    $request->validate([
			    'phone' => 'required|regex:/\+[0-9]{12}/',
                'user_id' => 'required'
		    ]);

		    $user = User::findOrFail($request->user_id);
		    $user->phone = $request->phone;
		    $user->save();

            $verification->delete($user->id);
		    $verification_token = $verification->create($user, $request->phone, 'phone');

		    TwilioService::sendSMS($request->phone, $verification_token);

            return response()->json(['status' => true]);
	    }

	    if($type == 'email'){
            $request->validate([
                'user_id' => 'required'
            ]);

            $user = User::findOrFail($request->user_id);

            $verification->delete($user->id);
            $verification_token = $verification->create($user, $user->email);

            $this->sendActivationMail($user, $verification_token['token'], $request);

            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

    /**
     * Handle a registration request for the application
     *
     * @param array $data
     * @return User
     */
    public function registerSocial(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param User $user
     * @param StoreAddService $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function addSpecializationsToUser(User $user, StoreAddService $request)
    {
        $data            = [];
        $specializations = $request->get('specializations');

        foreach ($specializations as $specialization) {
            $data[] = [
                'user_id'           => $user->id,
                'specialization_id' => $specialization,
                'accepted'          => 1,
                'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
            ];
        }

        DB::table('specialization_user')->insert($data);

//        $this->sendActivationMail($user, $request);

        $this->redirectTo = '/register';

        return redirect($this->redirectPath());
    }

    /**
     * Redirect user after registration
     * May be used in future
     *
     * @param User $user
     * @return bool
     *
     * @deprecated
     */
    protected function needSpecialization(User $user)
    {
        if ($user->isLogistic()) {
//            $this->redirectTo = '/specializations/register/' . $user->id;
//
//            return true;
            //todo:only for test
            $data[] = [
                'user_id'           => $user->id,
                'specialization_id' => Specialization::where('name', 'car_transport')->value('id'),
                'accepted'          => 1,
                'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
            ];
            DB::table('specialization_user')->insert($data);
        }

        $this->redirectTo = '/register';

        return false;
    }

    /**
     * Show the application's service form.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function showSpecializationsForm(User $user)
    {
        $specializations = Specialization::where('parent_id', 0)->get();

        return view('auth.specializations-register', ['user_id' => $user->id, 'specializations' => $specializations,]);
    }

    /**
     * Send activation mail
     *
     * @param User $user
     * @param Request $request
     */
    protected function sendActivationMail(User $user, $hash, Request $request)
    {
        $title = env('APP_NAME') . ' - ' . trans('all.activation_mail');

        Mail::to($user->email)->send(new ActivationLink($user, $hash, $title));

        $request->session()->flash('msg-send-email', trans('all.you_will_get_email_activation'));
        $request->session()->flash('msg-send-email-userId', $user->id);
    }

    /**
     * Create the necessary documents to the user
     * May be used in future
     *
     * @param User $user
     *
     * @deprecated
     */
    protected function addDefaultDocuments(User $user)
    {
        if ($user->isCompany()) {
            $documents = $user->roles()
                ->first()
                ->documents;

            if (!empty($documents)) {
                foreach ($documents as $document) {
                    Document::create([
                        'document_type_id' => $document->id,
                        'imagetable_id'    => $user->id,
                        'imagetable_type'  => User::class,
                    ]);
                }
            }
        }
    }

    public function verification($token, Request $request, VerificationService $verification){

        $type = $verification->checkToken($token);

        // if ajax
        if(!$type && $request->ajax()){
            return response()->json(['status' => false, 'text' => 'Код введен неправильный']);
        }

        if(!$type){
            return redirect('/');
        }

        $user = $verification->verification($token, $type);

        if($type == 'email') {
            if($user){
                // go to step #2 - register phone
                $request->session()->flash('register_phone_user', $user->id);
                return redirect()->route('register.phone');
            }
            else {
                $request->session()->flash('msg-send-fail', 'Токен устарел или введен неправильно. Попробуйте пройти регистрацию заново');
            }

            return view('auth.register');
        }

        // sms token
        if($type == 'phone'){
            if($user){//
                auth()->login($user);
                Mail::to($user->email)->send(new RegisteredUser($user));
                $request->session()->flash('msg-primary', trans('all.your_account_activated'));

	            // if user has pre order from lending
                if(isset($user->meta_data['pre_order_addresses']) || isset($user->meta_data['pre_order_cargo'])){
	                return response()->json(['status' => true, 'user' => $user->id, 'url' => '/order-create']);
                }

                return response()->json(['status' => true, 'user' => $user->id, 'url' => '/setting']);
            }
            return response()->json(['status' => false, 'text' => 'Код введен неправильный']);
        }

    }


	/**
	 * TODO remove in next version ??
	 *
	 * @deprecated
	 * @deprecated (?? $this->verification() ??)
	 *
	 * @param $token
	 * @param Request $request
	 * @param VerificationService $verification
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
//    public function activateUser($token, Request $request,  VerificationService $verification)
//    {
//        $type = $verification->checkToken($token);
////        $result = AuthController::activateUser($token);
//        $result = $verification->verification($token, $type);
//        if($result) {
//
//            auth()->login($result);
//            Mail::to($result->email)->send(new RegisteredUser($result, $request->get('password')));
//            $request->session()->flash('msg-primary', trans('all.your_account_activated'));
//
//            return redirect('/setting');
//        } else {
//            $request->session()->flash('msg-warning', trans('all.activation_not_found'));
//
//            return redirect()->to('/login');
//        }
//    }
}
