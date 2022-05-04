<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
//    use SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = ['read_at'/*, 'deleted_at'*/ , 'check_at'];
}
