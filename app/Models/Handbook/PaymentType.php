<?php

namespace App\Models\Handbook;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = 'payments_types';

    protected $fillable = [
        'name',
        'type',
    ];

    public $timestamps = false;

    public static function allStaff()
    {
        return static::whereType('staff')->get();
    }
}
