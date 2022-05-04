<?php

namespace App\Http\Controllers;

use Auth;
use Crypt;
use Cookie;
use Illuminate\Support\Facades\Session;
use Redirector;
use Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;


class SocialController extends Controller
{
    protected $redirectTo = '/home';

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param $provider
     * @param $role
     * @return Response
     */
    public function redirectToProvider($provider, $role = null)
    {
        if ($role) {
            Session::put('role', $role);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in
     * database by looking up their social_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in.
     *
     * @param $provider
     * @param Request $request
     * @return Response
     */
    public function handleProviderCallback($provider, Request $request)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        if ($authUser === null) {
            $errors = ['email' => trans('auth.failed')];
            return redirect('/login')->withErrors($errors);
        }

        Auth::login($authUser, true);

        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     *
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('social_id', $user->id)
                        ->orWhere('email', $user->email)
                        ->first();

        if ($authUser) {
            return $authUser;
        }

        if (!Session::has('role')) {
            return null;
        }

        $password = str_random(10);
        $data = [
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => bcrypt($password),
            'social_type' => $provider,
            'social_id' => $user->id,
            'is_activated' => 1,
            'phone' => null,
            'role' => Session::get('role'),
        ];

        $user = app()->make(RegisterController::class)->registerSocial($data);

        $this->sendPasswordMail($user, $password);

        Session::forget('role');

        return $user;
    }

    /**
     * @param User $user
     * @param $password
     */
    protected function sendPasswordMail(User $user, $password)
    {
        $title = env('APP_NAME') . ' - ' . trans('all.user_data_mail');;

        Mail::send(['html' => 'emails.auth-social'], ['email' => $user->email, 'password' => $password, 'title'=>$title], function ($m) use ($user) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->to($user->email, $user->name)->subject(env('APP_NAME').' - '.trans('all.activation_mail'));
        });

        Session::flash('msg-send-email', trans('all.you_will_get_email_data_user'));
    }
}
