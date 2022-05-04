<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Services\AmplitudeService;

use App\Jobs\CheckIfFillAccount;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    private $redirectTo = '/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param  mixed $user
     * @return bool
     */
    protected function isActivatedUser($user)
    {
        return ($user->verify_email && $user->verify_phone) ? true : false;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$this->isActivatedUser($user)) {
            $errors = [$this->username() => trans('validation.email_not_activate')];

            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            return redirect('/login')
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($errors);
        }

        $user->last_activity = \Carbon\Carbon::now();
        $user->save();

	    CheckIfFillAccount::dispatch(auth()->id());

	    (new AmplitudeService())->simpleRequest('Session start');
	    (new AmplitudeService())->request('Sign in', ['auth_method' => 'form']);
    }


    public function checkEmail(Request $request){
        $count = User::where('email', $request->get('email'))->count();
        if($count > 0)
            return response()->json(['result' => 'success']);
        else
            return response()->json(['result' => 'error', 'msg' => trans('all.user_not_found')]);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $data = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        if(config('captcha.google_recaptcha_check') !== false){
            $data['g-recaptcha-response']  = 'required|recaptcha:'.config('captcha.google_recaptcha_secret');
        }

        $this->validate($request, $data);
    }
}
