<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailActivation extends Model
{
    protected $table = 'email_activations';

    protected $fillable = ['email','user_id', 'token'];

    public $timestamps = false;
}
