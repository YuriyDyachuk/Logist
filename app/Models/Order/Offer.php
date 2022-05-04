<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Order\OrderPaymentType;
use App\Models\Order\OrderPaymentTerm;

class Offer extends Model
{
    protected $fillable = [
        'order_id',
        'sender_user_id',
	    'company_id',
        'user_id',
        'price',
        'payment_type_id',
        'payment_term_id',
        'vat',
        'amount_plan',
        'amount_fact'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function payment_type()
    {
        return $this->belongsTo(OrderPaymentType::class, 'payment_type_id');
    }


    /**
     * @return mixed
     */
    public function payment_term()
    {
        return $this->belongsTo(OrderPaymentTerm::class, 'payment_term_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'sender_user_id', 'id');
    }

	public function company()
	{
		return $this->belongsTo(User::class, 'company_id', 'id')->first();
	}

    public function executor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
