<?php

namespace App\Services\Cron;

use Carbon\Carbon;
use App\Models\Notification;

class ClearNotificationService {

    private $interval;

	public function __construct() {
		$this->interval = config('innlogist.clear_interval');
	}

	public function clearRequests($interval = null){

        if($interval !== null){
            $this->interval = $interval;
        }

        $notifications = [
            'App\Notifications\NewRequest',
            'App\Notifications\RequestOfferIncome',
        ];

        $date = Carbon::now()->subMinutes($this->interval);
        Notification::where('created_at', '<', $date->format('Y-m-d H:i:s'))->whereIn('type', $notifications)->update(['read_at' => now()]);
    }
}