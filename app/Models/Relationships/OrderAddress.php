<?php

namespace App\Models\Relationships;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $table = 'order_addresses';

    protected $fillable = ['order_id', 'address_id', 'type', 'date_at'];

    public $timestamps = false;
}
