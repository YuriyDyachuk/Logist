<?php

namespace App\Services;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Verification;

use Carbon\Carbon;

class VerificationService
{

    private $verify_type_array = [
        'email' => 1,
        'phone' => 2,
    ];

    private $verify_type_default = 'email';

    private $expired_at, $expire, $verify_type, $verify_type_id, $token;

    public function __construct()
    {
        $this->expire = config('verification.expire');
        $this->expired_at = Carbon::now()->addSeconds($this->expire);
    }

    private function checkType($type){
        if($type && array_key_exists($type, $this->verify_type_array)){
            $this->verify_type = $type;
            $this->verify_type_id = $this->verify_type_array[$type];
        } else {
            $this->verify_type = $this->verify_type_default;
            $this->verify_type_id = $this->verify_type_array[$this->verify_type_default];
        }
    }

    public function create($user, $value, $type = false){

        $this->checkType($type);

        $this->{'set'.ucfirst($this->verify_type).'Token'}();

        Verification::create([
            'user_id'       => $user->id,
            'verify_type'   => $this->verify_type_id,
            'verify_value'  => $value,
            'verify_token'   => $this->token,
            'expired_at'    => $this->expired_at,
        ]);

        return ['token' => $this->token, 'type' => $this->verify_type];
    }

    public function delete($userId){
        Verification::where('user_id', $userId)->delete();
    }

    /**
     * Code verification
     *
     * @param $token
     * @param bool $type
     * @return bool|object
     */
    public function verification($token, $type = false){

        $this->checkType($type);

        $timeNow = Carbon::now();

        $verification = Verification::whereVerifyType($this->verify_type_id)->where('expired_at', '>', $timeNow)->whereVerifyToken($token)->whereNull('verify_at')->first();

        if($verification && $verification->verify_at){
            return User::findOrFail($verification->user_id);
        }

        if($verification && !$verification->verify_at){
            $verification->verify_at = $timeNow;
            $verification->save();

            $user = User::findOrFail($verification->user_id);

            $user->{'verify_'.$this->verify_type} = 1;
            $user->is_activated = true;
            $user->verified = true;
            $user->save();

            return $user;
        }

        return false;
    }

    private function setEmailToken(){
        $this->token = Str::random(60);
    }

    private function setPhoneToken(){
        $this->token = rand(1000,9999);
    }

    /**
     *
     * Checking for correct token
     *
     * @param $token
     * @return bool
     */
    public function checkToken($token){
        $str = str_split ($token);

        if(count($str) == 60){
            return 'email';
        }

        if(count($str) == 4 && preg_match('/[\d]{4}/', $token)){
            return 'phone';
        }

        return false;
    }
}