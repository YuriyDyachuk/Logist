<?php

namespace App\Http\Controllers\Auth;

use App\Models\Client;
use App\Notifications\InviteToSystem;
use App\ModelsUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use \App\Models\User;
use App\Mail\InviteClient;
use Mail;

class InvitationController extends Controller
{
    private $account = 'client';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form if redirect to main page
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm($token)
    {
        if ($user = $this->attemptRegister($token)) {
            $client     = Client::whereClientId($user->id)->first();
            if (is_string($client->data)) {
                $user->data = json_decode($client->data);
            } else {
                $user->data = $client->data;
            }

            return view('auth.profile-register', ['account' => $this->account, 'data' => ['user' => $user]]);
        }

        return redirect('/');
    }

    /**
     * Attempt to register the user into the application.
     *
     * @param $token
     * @return mixed
     */
    private function attemptRegister($token)
    {
        return User::whereRememberToken($token)->first();
    }

    /**
     * @param User $sender
     * @param User $recipient
     */
    public static function send(User $sender, User $recipient)
    {
        $token = $token = str_random(60);
        $recipient->forceFill(['remember_token' => $token])->save();

        Mail::to($recipient->email)->send(new InviteClient($sender, $recipient, $token));
    }
}
