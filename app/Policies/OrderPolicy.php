<?php

namespace App\Policies;

use App\Enums\OrderStatus;
use App\Models\User;
use App\Models\Order\Order;
use App\Models\Partner;
use App\Models\PartnerStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Order\Order $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        $user_order = User::find($order->user_id);

        return
            $order->user_id == $user->id || /*user can see own order*/
            $user->id == $user_order->parent_id || /*logistic company can see order from logists*/
            $order->getPerformer() || /*if user executor*/
            $order->getOffer(); /* user (logistic and his logist) can see offers */
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Order\Order $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
	    //
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Order\Order $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        //
    }

	/**
	 * Determine whether the user can edit cargo.
	 *
	 * @param User $user
	 * @param Order $order
	 *
	 * @return bool
	 */
    public function order_edit_cargo(User $user, Order $order){
	    return $order->user_id === $user->id && $order->hasStatus('planning');
    }
}
