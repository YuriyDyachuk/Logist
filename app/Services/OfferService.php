<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order\Order;
use App\Enums\TransportStatus;
use App\Models\Status;
use App\Models\Transport\Transport;
use App\Models\Order\OfferOrder;
use App\Models\Order\Offer;
use App\Models\Order\OrderPerformer;
use App\Models\Partner;

class OfferService
{
    private $order;
    private $user;
    private $owner_id;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->user = \Auth::user();
    }

    public function searchSuitablePerformers($except_user_id = null){

	    $except_user_id_array = null;
		if($except_user_id !== null){
			$except_user_id_array = [$except_user_id];
	    }

        $users = false;

	    $sender_user_id = $this->order->getPerformer()->sender_user_id;
	    $user = User::find($sender_user_id);

        if($user->isClient()){
            // if order created by client - send to logist and owner
            $users = $this->searchSuitablePerformersFromClient($except_user_id_array);
	        $this->user = $user;
        } else {
            // send to owner and partner
            $users = $this->searchSuitablePerformersFromLogist();
        }

        $transports = 0;
        $transports_users_id = [];

        $usersSuitable = collect();

        if($users !== false){

            $transports = $this->getOwnerTransportByCriteria($users);

            if($transports->isNotEmpty()){
                $transports_users_id = $transports->pluck('user_id')->unique();

	            if($user->isClient()){
		            $amplitude[] = [
			            'send_by_client' => true
		            ];
		            (new AmplitudeService())->request('Get new request', $amplitude);
	            }

                foreach ($transports_users_id as $user_id){
		                $this->storeUserOffer($user_id);

		                $user = $users->filter(function ($item, $key) use ($user_id) {
			                return $item->id == $user_id;
		                });
						$usersSuitable = $usersSuitable->merge($user);
                }
            }
        }

        OfferOrder::updateOrCreate(['order_id' => $this->order->id], ['amount' => count($transports_users_id)]);

        if($transports->count() > 0){
//            return $users;
            return $usersSuitable;
        }

        return false;
    }

    private function searchSuitablePerformersFromClient($except_user_id_array = null){

        // TODO now for all company
        $users_query = User::query()
            ->where([['users.verified', '=', true], ['users.is_activated', '=', true]])

            ->whereHas('roles', function($q){
                $q->/*getMainRoles()*/where('roles.id', 1); // for all logistics company;
            });

	    if($except_user_id_array !== null && is_array($except_user_id_array)){
		    $users_query ->whereNotIn('id', $except_user_id_array);
	    }

        $users = $users_query->get();

        return $users->isNotEmpty() ? $users : false;
    }

    private function searchSuitablePerformersFromLogist(){
        $this->owner_id = ($this->user->parent_id == 0) ? $this->user->id : $this->user->parent_id;

        $owner_id = $this->owner_id;

//        $partners = Partner::where('user_id', $this->owner_id)->approved()->pluck('partner_id');
        $partners = $this->user->getAcceptetPartners()->pluck('id');

        $users = User::query()
            ->where([['users.verified', true], ['users.is_activated', true]])
            ->where(function($q) use ($owner_id, $partners) {
                $q->where('id', $owner_id)
                    ->orWhereIn('id', $partners);
            })
            ->get();

        return $users->isNotEmpty() ? $users : false;
    }


    public function getOwnerTransportByCriteria($users)
    {
        $users_ids = $users->pluck('id');

        return Transport::has('drivers')
//            ->where('user_id', $this->owner_id)
            ->whereIn('user_id', $users_ids)
            ->where('status_id', Status::getId(TransportStatus::FREE))
//            ->where('height', '>=', $this->order->cargo->height)
//            ->where('length', '>=', $this->order->cargo->length)
//            ->where('width', '>=', $this->order->cargo->width)
//            ->where('weight', '>=', ($this->order->cargo->weight/1000)) /* TODO KG to TON*/
//            ->where('volume', '>=', $this->order->cargo->volume)
            ->get();
    }

    public function storeUserOffer($user_id, $price = null, $request = null){

        $performer = OrderPerformer::whereOrderId($this->order->id)->whereUserId($this->user->id)->first();

        $payment_type_id = $performer ? $performer->payment_type_id : null;
        $payment_term_id = $performer ? $performer->payment_term_id : null;
        $vat = $performer ? $performer->vat : null;
        $amount_plan = $performer ? $performer->amount_plan : null;

        if($request && $request->has('offer_partner')) {
            $amount_plan = floatval($request->offer_partner);
            $vat = $request->offer_partner_vat;
            $payment_type_id = $request->offer_partner_payment_type;
            $payment_term_id = $request->offer_partner_payment_term;
        }

        Offer::updateOrCreate(
            [
                'order_id' => $this->order->id,
                'sender_user_id'  => $this->user->id,
                'company_id'  => $user_id,

            ],
            [
                'user_id'  => $user_id,
                'payment_type_id' => $payment_type_id,
                'payment_term_id' => $payment_term_id,
                'vat'      =>  $vat,
                'amount_fact'  => $price,
                'amount_plan'    => $amount_plan,
            ]);
    }

    public function getStoredOffer(){
        return Offer::where('order_id', $this->order->id)->where('sender_user_id', $this->user->id)->get();
    }

    public function deleteOffers(){
        return Offer::where('order_id', $this->order->id)->delete();
    }

	public function deleteOfferOrder(){

	}
}