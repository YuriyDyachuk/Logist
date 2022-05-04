<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['order_id', 'user_id', 'company_id', 'transport_id', 'driver_id', 'comment', 'rating'];


    public static function boot() {
        parent::boot();

//        self::creating(function($model){
//            $user = auth()->user();
//            $model->user_id = $user->id;
//            $model->company_id = ($user->parent_id != 0) ? $user->parent_id : $user->id;
//        });
    }

    public function driver(){
        return $this->belongsTo('App\Models\User', 'driver_id', 'id');
    }

    /**
     * @param $n
     * @param $titles
     * @return mixed
     * Testimonial rating star (recommendations)
     */
    public static function number($n, $titles) {
        $number = array(2, 0, 1, 1, 1, 2);
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $number[min($n % 10, 5)]];
    }

}
