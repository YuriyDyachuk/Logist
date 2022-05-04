<?php

namespace App\Models;

use Rinvex\Subscriptions\Traits\HasSubscriptions;
use Illuminate\Database\Eloquent\Model;


class UserCompany extends Model
{
    use HasSubscriptions;

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password',
//        'remember_token',
//        'is_activated',
//        'balance',
//        'balance_return',
//        'social_type',
//        'social_id',
//        'meta_data',
//        'parent_id',
//        'invited',
//        'locale',
//        'verified',
//        'tutorial'
//    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//        'role_id',
//        'phone',
//        'is_activated',
//        'balance',
//        'balance_return',
//        'social_type',
//        'social_id',
//        'meta_data',
//        'parent_id',
//        'invited',
//        'locale',
//        'verified',
//        'tutorial'
//    ];

//    public function newQuery()
//    {
//        return parent::newQuery()
//            ->join('role_user', function ($join) {
//                $join->on('users.id', '=', 'role_user.user_id')->whereIn('role_user.role_id', [1,2]);
//            });
//    }
//
//    public function getAvatar()
//    {
//        return $this->images()->first()->filename ?? '';
//    }
}
