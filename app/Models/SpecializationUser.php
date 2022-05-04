<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecializationUser extends Model
{
    protected $table = "specialization_user";

    protected $fillable = ['user_id', 'specialization_id', 'accepted'];

    public function info()
    {
        return $this->belongsTo('App\Models\Specialization', 'specialization_id', 'id');
    }

}
