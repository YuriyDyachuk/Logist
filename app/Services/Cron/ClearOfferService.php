<?php
namespace App\Services\Cron;

use Carbon\Carbon;
use App\Models\Order\Offer;
use App\Models\Order\OfferOrder;

use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestNoOffers;

class ClearOfferService {

	private $interval;

	public function __construct() {
		$this->interval = config('innlogist.clear_interval');
	}

    public function clearRequests($interval = null){
        if($interval !== null){
            $this->interval = $interval;
        }

		$date = Carbon::now()->subMinutes($this->interval);

		$offers_query = Offer::where('created_at', '<=', $date->format('Y-m-d H:i:s'))->whereNull('amount_fact');

		$offers = $offers_query->with('creator')->get();

		if($offers->isNotEmpty()){

		    // clear offers
            $offers_unique = $offers->unique('order_id')->pluck('order_id');
            OfferOrder::whereIn('order_id', $offers_unique)->update(['amount' => 0]);
            $offers_query->delete();

            // send notification to creators of order
//            $users_unique = $offers->unique('sender_user_id')->pluck('sender_user_id');
            $users_order_unique = $offers->unique(function ($item) {
                return $item['sender_user_id'].$item['order_id'];
            });

            foreach($users_order_unique as $offer){
                Notification::send($offer->creator, (new RequestNoOffers($offer->order_id)));
            }

        }
	}
}