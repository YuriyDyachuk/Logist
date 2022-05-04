<?php
/**
 * Created by PhpStorm.
 * User: ams3
 * Date: 12.10.2017
 * Time: 14:44
 */

namespace App\Search\Order\Filters;

use App\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

use App\Enums\UserRoleEnums as Roles;

use App\Models\User;
use App\Models\Role;

class WithoutOwn implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        $user_current = \Auth::user();

        $logists_array = [];
        // logistic can see orders from logist
        if ($user_current->parent_id === null) {
            $logists = User::where('parent_id', $user_current->id)->whereHas('roles', function($q){
                $q->getMainStaff();
            })->pluck('id');
            if($logists->isNotEmpty()) 
                $logists_array = $logists->toArray();
            $user_array = array_merge([$user_current->id], $logists_array);

        }
        else {
            $role_id = Role::getRoleIdByName(Roles::LOGIST);
            $co_logists_array = [];
            $logists = User::where('parent_id', $user_current->parent_id)
                ->whereHas('roles', function($q) use($role_id) {
                    $q->where('roles.id', $role_id);
                })
                ->pluck('id');
            if($logists->isNotEmpty()) 
                $co_logists_array = $logists->toArray();

            $user_array = array_merge([$user_current->parent_id], $co_logists_array);
        }
        
//        return $builder->whereHas('performers', function($q) use ($user_array){
//            $q->whereNotIn('user_id', $user_array);
//        });

        return $builder->whereNotIn('user_id', $user_array);
    }
}