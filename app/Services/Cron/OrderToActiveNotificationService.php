<?php

namespace App\Services\Cron;

use App\Enums\OrderStatus;

use App\Models\Status;
use App\Models\Order\Order;
use App\Models\Notification as NotificationModel;
use App\Models\User;

use Illuminate\Support\Facades\Notification;

use App\Notifications\OrderToActive;

use Carbon\Carbon;

/**
 * Class OrderToActiveNotificationService
 * @package App\Services\Cron
 */
class OrderToActiveNotificationService
{

    /**
     * @var int
     */
    private static $notification_period = 10; // minutes

    public static function getPlanningOrders(){
        $order_status = Status::getId(OrderStatus::PLANNING);

        $date = Carbon::now()->subMinutes(self::$notification_period);

        $orders = Order::where('current_status_id', $order_status)->where('created_at', '<', $date)->with('performers')->get();

        if($orders->isNotEmpty()){
            foreach ($orders as $order){
                $performer = $order->performers !== null ? $order->performers->last() : false;

                if($performer){

                    NotificationModel::whereType('App\Notifications\OrderToActive')->where('notifiable_id', $performer->user_id)->WhereNull('read_at')->delete();

                    $user = User::findOrFail($performer->user_id);
                    $user ? Notification::send($user, (new OrderToActive($order->id))) : logger('User not found: '.$performer->user_id);
                }
            }
        }
    }
}