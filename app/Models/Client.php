<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = ['user_id', 'client_id', 'data', 'is_system'];

    protected $casts = [
        'data' => 'array',
    ];

    public function orders(){
        return $this->hasMany('App\Models\ClientOrder', 'client_id', 'client_id');
    }

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'client_id');
    }

    public function parent(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
