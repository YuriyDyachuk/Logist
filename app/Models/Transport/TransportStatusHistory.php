<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportStatusHistory extends Model
{
    protected $table = 'transport_statuses';

    protected $fillable = ['transport_id', 'status_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function transport()
    {
        return $this->belongsTo('App\Models\Transport\Transport');
    }
}