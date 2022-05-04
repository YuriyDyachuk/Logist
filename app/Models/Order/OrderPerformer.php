<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Order\OrderPaymentType;
use App\Models\Order\OrderPaymentTerm;
use App\Models\User;

class OrderPerformer extends Model
{
    use SoftDeletes;

    protected $table = 'order_performers';

    protected $fillable = [
        'order_id',
        'user_id',
        'sender_user_id',
        'transport_id',
        'payment_type_id',
        'payment_term_id',
        'vat',
        'amount_plan',
        'amount_fact',
	    'debtdays',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order\Order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    public function executor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
