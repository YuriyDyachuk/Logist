<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportKey extends Model
{
    protected $table = 'transport_keys';

    protected $fillable = ['name'];

//    public $timestamps = false;
}
