<?php

namespace App\Http\Middleware;

use Closure;

use App\Enums\OrderStatus;

use Illuminate\Support\Facades\Notification;

use App\Models\Order\Order;
use App\Models\Status;
use App\Models\Notification as NotificationModel;

use App\Notifications\ReminderToLeaveTestimonial;

class CheckOrderTestimonial
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if($user && $user->isClient()){
            $order_status = Status::getId(OrderStatus::COMPLETED);
            $orders = Order::whereUserId($user->id)->whereCurrentStatusId($order_status)->doesntHave('testimonial')->get();

            if($orders->isNotEmpty()){
	            $notification = NotificationModel::whereType('App\Notifications\ReminderToLeaveTestimonial')->whereNotifiableId($user->id)->whereNull('read_at')->get();

	            if($notification->isEmpty())
	            {
                    foreach($orders as $order){
                        Notification::send($user, new ReminderToLeaveTestimonial($order));
                    }
                }
            }
        }

        return $next($request);
    }
}
