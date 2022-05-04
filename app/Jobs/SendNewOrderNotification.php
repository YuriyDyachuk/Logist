<?php

namespace App\Jobs;

use App\Models\Order\Order;
use App\Notifications\NewRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewOrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const DELAY_SECONDS = 1800;

    /**
     * @var Order
     */
    public $order;

    /**
     * @var array
     */
    public $params;

    public  $suitableUsers;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @param array $params
     * @return void
     */
//    public function __construct(Order $order, array $params, OfferService $offerService)
    public function __construct(Order $order, $suitableUsers)
    {
        $this->order  = $order;
        $this->suitableUsers  = $suitableUsers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->suitableUsers){
            Notification::send($this->suitableUsers, (new NewRequest($this->order)));
        }

    }
}
