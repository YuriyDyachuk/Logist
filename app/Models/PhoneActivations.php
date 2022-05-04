<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneActivations extends Model
{
    protected $table = 'phone_activations';

    protected $fillable = ['user_id', 'phone', 'code', 'verified'];

    public function getPhone()
    {
        return $this->phone;
    }
}
