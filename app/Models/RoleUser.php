<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role;
use App\Enums\UserRoleEnums;

class RoleUser extends Model
{
    protected $table = 'role_user';

    protected $fillable = ['role_id', 'user_id'];

    /**
     * @param array Role $id
     * @return array User $id
     */
    public static function getUsersID($id)
    {
        $arr = [];
        $res = self::whereIn('role_id', $id)->get();

        foreach ($res as $item) {
            $arr[] = $item->user_id;
        }

        return $arr;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getDrivers($userId, $available = false)
    {
        $res = $this->whereHas('user', function($q) use($userId) {
            $q->where('parent_id', $userId);

        })
            ->where('role_id', Role::getRoleIdByName(UserRoleEnums::DRIVER))
            ->when($available, function ($query) use ($available) {
                return $query->whereNotExists(function($query)
                {
                    $query->select(\DB::raw(1))
                        ->from('transports_drivers')
                        ->whereRaw('transports_drivers.user_id = '.$this->table . '.user_id');
                });
            })
            ->join('users', 'role_user.user_id', '=', 'users.id');;

        return $res->get();
    }
}
