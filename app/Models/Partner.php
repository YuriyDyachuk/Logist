<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PartnerStatus;

class Partner extends Model
{
    protected $table = 'partners';

    protected $fillable = ['user_one_id', 'user_two_id', 'status_id', 'action_user_id'];

    public function status(){
        return $this->belongsTo('App\Models\PartnerStatus');
    }

    public static function storePartner($partner_id, $status_id = null){
        $user = \Auth::user();

        list($id_one, $id_two) = self::userIdSort($user->id, $partner_id);

        if(!$status_id){
            $status_id = PartnerStatus::getId(PartnerStatus::PENDING);
        }

        $data_search = [
            'user_one_id'   => $id_one,
            'user_two_id'   => $id_two,
        ];

        $data = [
            'status_id'     => $status_id,
            'action_user_id'=> $user->id,
        ];

        return self::updateOrCreate($data_search, $data);
    }

    public static function deletePartner($partner_id){
        $user = \Auth::user();

        $userId = ($user->parent_id !=0 && $user->is_admin == 1) ? $user->parent_id : $user->id;

        list($id_one, $id_two) = self::userIdSort($userId, $partner_id);

        return self::where('user_one_id', $id_one)->where('user_two_id', $id_two)->delete();
    }

    public static function isPartnerAccepted($id_one, $id_two){
        return self::isPartner($id_one, $id_two, PartnerStatus::getId(PartnerStatus::ACCEPTED));
    }

    public static function isPartner($id_one, $id_two, $status = null){

        list($id_one, $id_two) = self::userIdSort($id_one, $id_two);

        $result_query = self:: where('user_one_id', $id_one)->where('user_two_id', $id_two)->with('status');

        if($status){
            $result_query->where('status_id', $status);
        }

        return $result_query->first();
    }

    public function scopeApproved($query){
        return $query->where('invite_approved',1);
    }

    private static function userIdSort($id_one, $id_two){
        if($id_one > $id_two){
            $id_one_tmp = $id_one;
            $id_one = $id_two;
            $id_two = $id_one_tmp;
        }

        return [$id_one, $id_two];
    }
}
