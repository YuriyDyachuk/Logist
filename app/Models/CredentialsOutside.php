<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CredentialsOutside extends Model
{
    protected $table = 'credentials_outside';

    public $timestamps = false;

    protected $fillable = ['user_id', 'login', 'password', 'api_key', 'type'];

    protected $hidden = ['password', 'api_key'];
}
