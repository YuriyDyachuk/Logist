<?php

namespace App\Services;

use App\Models\User;

class LogisticService {

	/**
	 * Get Logists Users Array
	 *
	 * @return array
	 */
    public static function getLogistsArray() {

	    $user = auth()->user();

	    $logists_array = [];

	    $role_id = \App\Enums\UserRoleEnums::LOGIST;

	    if($user->isLogistic()){
		    $logists = User::where('parent_id', $user->id)->whereHas('roles', function($q) use ($role_id){
			    $q->where('role_id', $role_id);
		    })->pluck('id');
		    $logists_array = $logists->toArray();
	    }

	    if($user->isLogistAndAdmin()){

		    $logists = User::where('parent_id', $user->parent_id)->whereHas('roles', function($q) use ($role_id){
			    $q->where('role_id', $role_id);
		    })->pluck('id');

//		    $logists = User::where('parent_id', $user->parent_id)->pluck('id');
		    $owner = User::where('id', $user->parent_id)->pluck('id');
		    $logists_array =  array_merge($logists->toArray(),$owner->toArray()) ;
	    }

	    return array_unique(array_merge($logists_array, [$user->id]));
    }

}
