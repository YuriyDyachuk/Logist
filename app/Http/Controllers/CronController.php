<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Cron\ClearOfferService;
use App\Services\Cron\ClearNotificationService;
use App\Services\Cron\OrderToActiveNotificationService;
use App\Services\Cron\PaymentReminder;

/**
 * Class CronController
 * @package App\Http\Controllers
 */
class CronController extends Controller
{

	public function clearOffers(){
        \Debugbar::disable();

		$this->offers();
		$this->notifications();
	}

	private function offers(){
		$offers = new ClearOfferService();
		$offers->clearRequests();
	}

	private function notifications(){
        $notifications = new ClearNotificationService();
        $notifications->clearRequests();
	}

	public function orderToActive(){
        \Debugbar::disable();

        OrderToActiveNotificationService::getPlanningOrders();
    }

    public function paymentReminder(){
	    \Debugbar::disable();

	    new PaymentReminder();
    }
}
