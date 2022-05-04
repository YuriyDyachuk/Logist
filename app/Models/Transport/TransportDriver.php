<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportDriver extends Model
{
    protected $table = 'transports_drivers';

    protected $fillable = ['user_id', 'transport_id'];
}
