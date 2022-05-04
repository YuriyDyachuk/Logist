<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Carbon\Carbon;

/**
 * Class NotificationController
 * @package App\Http\Controllers
 */
class NotificationController extends Controller
{

    /**
     * @var int
     */
    private $notification_period = 20; // minutes

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $id)
    {
//		logger('USER ID notification '. $id);
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            // Напоминание клиенты оставить отзыв
            if($notification->type === 'App\Notifications\ReminderToLeaveTestimonial'){
                return redirect()->route('orders.show', $notification->data['order_id'] );
            }
            // Напоминание логисту активировать заказ
            else if($notification->type === 'App\Notifications\OrderToActive'){
                return redirect()->route('orders.show', $notification->data['order_id'] );
            }
            // Уведомление клиенту о завершении заказа
            else if($notification->type === 'App\Notifications\CompletedOrder'){
                return redirect()->route('orders.show', $notification->data['order_id'] );
            }

            // Уведомление о необходимости дозаполнить профиль сотрудника
            else if($notification->type === 'App\Notifications\FillUncompletedStaff'){
	            return redirect()->route('user.profile' );
            }

            // Уведомление о необходимости дозаполнить профиль транспорта
            else if($notification->type === 'App\Notifications\FillUncompletedTransport'){
	            return redirect()->route('transport.edit', ['id' => $notification->data['transport_id']] );
            }

            return redirect()->route('orders');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $notification = Notification::query()->find($id);

        if ($request->expectsJson() && $notification) {
            $notification->update(['read_at' => Carbon::now()]);
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'not found'], 404);
    }

    /**
     * Check for new
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(){
        $user = auth()->user();
        if(!$user){
	        return response()->json([]);
        }

	    $date = Carbon::now()->subMinutes($this->notification_period);

        $result = Notification::whereNotifiableId($user->id)
	        ->where('created_at', '>', $date)
	        ->whereNull('read_at')
	        ->whereNull('check_at')
            ->get();

	    $amount = $result->count();

	    if($amount > 0){
		    Notification::whereIn('id', $result->pluck('id'))->update(['check_at'=> Carbon::now()]);
	    }

        return response()->json(['amount' => $amount]);
    }
}
