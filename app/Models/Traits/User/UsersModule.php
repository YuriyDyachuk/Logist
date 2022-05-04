<?php

namespace App\Models\Traits\User;

use App\Models\Module;
use App\Models\RoleModule;
use App\Models\User;


trait UsersModule
{

    public static function userCurrentCan($module_name, $action = false){
        $user = \Auth::id();
        return self::userCan($user, $module_name, $action);
    }

    public static function userCan($user, $module_name, $action = false){

        if(!$action){
            $action = 'read';
        }

        $module = Module::where('name', $module_name)->first();

        if(!$module){
            return false;
        }

        if(!is_object($user)){
            $user = User::findOrFail($user);
        }

        $role_id = $user->getRole()->id;

        $result = RoleModule::where('role_id', $role_id)->where('module_id', $module->id)->first();

        if($result && in_array($action, ['create', 'read', 'update', 'delete'])){
            return ($result->{$action} == 1) ? true : false;
        }

        return false;
    }
}