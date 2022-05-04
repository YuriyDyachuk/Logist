<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $table = 'users_devices';

    protected $guarded = [];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    static public function setUserDevice($user_id, $request){

        if($request->has('gcm_token') && !empty($request->gcm_token)){

            self::where('user_id', $user_id)->delete();

            return self::create([
                'user_id'       => $user_id,
                'gcm_id'        => $request->gcm_token,
            ]);
        }
        else {
            return 'No GCM ID';
        }

    }
}
