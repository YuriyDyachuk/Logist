<?php

namespace App\Models\Traits\User;

use App\Enums\UserRoleEnums;
use App\Models\Role;
use App\Models\RoleUser;
use App\Enums\UserRoleEnums as Roles;

trait UsersRole
{
    /**
     * @return mixed
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

	/**
	 * @return mixed
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function role()
	{
		return $this->hasOne(RoleUser::class);
	}

	/**
	 * Role id
	 *
	 * @return object|bool
	 */
	public function getRoleId()
	{
		if ($this->roles()->first()) {
			return $this->roles()->first()->id;
		}

		return false;
	}

    /**
     * Role name
     *
     * @return string name
     */
    public function getRoleName()
    {
        if ($this->roles()->first()) {
            return $this->roles()->first()->name;
        }

        return false;
    }

    /**
     * Role
     *
     * @return object|bool
     */
    public function getRole()
    {
        if ($this->roles()->first()) {
            return $this->roles()->first();
        }

        logger('User has not role. id:', ['id' => $this->id]);

        return false;
    }

    /**
     * Check role
     *
     * @return bool
     */

    public function hasRole($role)
    {
        return $this->roles()->whereName($role)->count() > 0;
    }

    /**
     * True if the account is logistic company
     *
     * @return bool
     */
    public function isLogistic()
    {
        return $this->hasRole(Roles::LOGISTIC);
    }

    /**
     * True if the account is client company
     *
     * @return bool
     */
    public function isClient()
    {
        return $this->hasRole(Roles::CLIENT);
    }

    /**
     * True if the account is driver
     *
     * @return bool
     */
    public function isDriver()
    {
        return $this->hasRole(Roles::DRIVER);
    }

    /**
     * True if the account is logist
     *
     * @return bool
     */
    public function isLogist()
    {
        return $this->hasRole(Roles::LOGIST);
    }

	/**
	 * True if the account is admin(for logist)
	 *
	 * @return bool
	 */
    public function isAdmin(){
        return $this->is_admin == 1 ? true : false;
    }

	/**
	 * True if the account is logist and admin
	 *
	 * @return bool
	 */
    public function isLogistAndAdmin()
    {
		return $this->isLogist() && $this->isAdmin();
    }

	/**
	 * Get Staff by role name
	 *
	 * @return object
	 */
	public function getCompanyStaffByRoleName($role_name)
	{
		$role_id = Role::getRoleIdByName($role_name);

		$users = self::where('parent_id', $this->id)->whereHas('roles', function($q) use ($role_id){
			$q->where('role_id', $role_id);
		})->get();

		return $users;
	}

    /**
     * True if the account is freelance or company
     *
     * @return bool
     */
    public function isCompany()
    {
        if ($this->roles()->first()) {
            return $this->roles()->first()->type == 1 ? true : false;
        }
        return false;
    }

	/**
	 * Return type of company
	 *
	 * @return bool
	 */
	public function getType(){
		$role = $this->getRole();

		if($role){
			return $role->type;
		}

		return false;
	}

	public static function getUserRoleId($user_id){
	    return RoleUser::whereUserId($user_id)->first();
    }

    public static function getUserRoleName($user_id){
	    $role = self::getUserRoleId($user_id);

	    return Role::getRoleNameById($role->role_id);
    }
}