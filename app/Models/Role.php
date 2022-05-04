<?php

namespace App\Models;

use App\Models\Document\DocumentType;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Module;

class Role extends Model
{
    protected $table = 'roles';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(DocumentType::class, 'document_role', 'role_id', 'document_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specializations()
    {
        return $this->belongsToMany('App\Models\Specialization', 'specialization_role', 'role_id', 'specialization_id')->withTimestamps();
    }

    /**
     * @param string $name
     * @return array Role id
     */
    public static function getTypeID($name)
    {
        $id    = [];
        $roles = self::where('name', 'LIKE', $name . '%')
            ->get()
            ->toArray();

        foreach ($roles as $role) {
            $id[] = $role['id'];
        }

        return $id;
    }

    /**
     * @return array User id
     */
    public static function logistic()
    {
        $id    = [];
        $roles = RoleUser::query()->whereIn('role_id', self::getTypeID('logistic'))
            ->get()
            ->toArray();

        foreach ($roles as $role) {
            $id[] = $role['user_id'];
        }

        return $id;
    }

	public function children()
	{
		return $this->hasMany(Role::class,'parent_id');
	}

	public function scopeGetMainRoles($query){
		return $query->where('parent_id', 0)->with('children');
	}

	/**
	 * Get role ID by name
	 *
	 * @return object|bool
	 */
	public static function getRoleIdByName($name){
		$role = self::where('name', $name)->first();
		return $role ? $role->id : false;
	}

    /**
     * Get role name by ID
     *
     * @return object|bool
     */
    public static function getRoleNameById($id){
        $role = self::whereId($id)->first();
        return $role ? $role->name : false;
    }
}
