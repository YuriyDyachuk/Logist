<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Verification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'verify_type',
        'verify_value',
        'verify_token',
        'verify_at',
        'expired_at',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
