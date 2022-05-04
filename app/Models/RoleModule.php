<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Role;
use App\Models\Module;

class RoleModule extends Model
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
