<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientOrder extends Model
{
    protected $table = "client_order";

    public function client(){
        return $this->belongsTo('App\Models\Client', 'client_id', 'id');
    }
}
