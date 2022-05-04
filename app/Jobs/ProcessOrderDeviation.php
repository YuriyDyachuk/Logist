<?php

namespace App\Jobs;

use Exception;
use App\Models\Order\Order;
use App\Models\OrderGeo;
use App\Models\User;
use App\Notifications\OrderDeviation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Notification;

class ProcessOrderDeviation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    private $orderId;

    private $performerUserId;

    /**
     * Create a new job instance.
     *
     * @param $orderId
     * @param $performerUserId
     */
    public function __construct($orderId, $performerUserId)
    {
        $this->orderId = $orderId;

        $this->performerUserId = $performerUserId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle():void
    {
        $order     = Order::query()->findOrFail($this->orderId);
        $performer = $order->getPerformerTransport($this->performerUserId);
        $creator   = User::query()->findOrFail($performer->user_id);

        if (!$creator->isDeviationEnabled()) {
            return;
        }

        $query = OrderGeo::where('order_id', $this->orderId)
            ->where('deviation', '>', $creator->getDeviationDistance())
            ->orderBy('datetime', 'desc')
            ->limit(1);

        if (isset($order->meta_data['last_deviation'])) {
            $query = $query->where('datetime', '>', $order->meta_data['last_deviation']);
        }

        $geo = $query->get();
        if ($geo->isEmpty()) {
            return;
        }

        $env                          = (string) config('app.env');
        $lastDeviationNotificationKey = $env . 'lastdeviationnotification_' . $this->orderId;
        $nowDate                      = Carbon::now();
        $redis                        = Redis::connection();
        $notificationKeyExists        = $redis->exists($lastDeviationNotificationKey);
        if ($notificationKeyExists) {
            $nextNotification = Carbon::parse($redis->get($lastDeviationNotificationKey))->addMinutes(30);
        } else {
            $nextNotification = $nowDate->addMinutes(30);
        }

        $timeNotExceeded = $nextNotification->greaterThan($nowDate);
        if ($timeNotExceeded && $notificationKeyExists) {
            return;
        }

        $latestGeoItem = $geo->first();
        $latestGeo = $latestGeoItem->toArray();
        if (!$order->rebuildDirectionAfterDeviation($latestGeo)) {
            return;
        }

        $order->meta_data = array_merge($order->meta_data, ['last_deviation' => $latestGeoItem->datetime]);
        $order->save();

        Notification::send($creator, new OrderDeviation($order));
        $redis->set($lastDeviationNotificationKey, Carbon::now()->toDateTimeString());
        $redis->expire($lastDeviationNotificationKey, 1800);
    }

    /**
     * @param \Exception $exception
     */
    public function failed(Exception $exception): void
    {
        Log::error($exception->getMessage());
    }
}
