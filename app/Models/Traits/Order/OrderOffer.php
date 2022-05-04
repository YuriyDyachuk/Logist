<?php

namespace App\Models\Traits\Order;

trait OrderOffer
{
    /**
     * @param $userId
     * @return bool
     */
    public function isUserSentOffer($userId = null)
    {
        if(is_null($userId)){
            $userId = \Auth::id();
        }

        return !empty($this->offers()->where('user_id', $userId)->where('price', '!=', 0)->first());
    }

    public function isCurrentUserSentOffer(){
        return $this->isUserSentOffer();
    }

    public function isItOffer($userId = null){
        if(is_null($userId)){
            $userId = \Auth::id();
        }

        return $this->offers()->where('user_id', $userId)->where('order_id', $this->id)->first() ? true : false;
    }

    public function getOffers(){
        return $this->offers()->whereNotNull('amount_fact')->get();
    }

    public function getOffer($userId = null){
        if(is_null($userId)){
            $user = \Auth::user();
            $userId = $user->id;
        }
        else {
            $user = \App\Models\User::findOrFail($userId);
        }
        $parentId = $user->parent_id;

        $filtered = $this->offers->filter(function ($value, $key) use ($userId, $parentId) {
            /* return for company owner and his logists*/
            return $value['company_id'] == $userId || $value['company_id'] == $parentId;
        });

        return $filtered->isNotEmpty() ? $filtered->first() : null;
    }

    public function getOfferSender($userId = null){
        if(is_null($userId)){
            $userId = \Auth::id();
        }

        $filtered = $this->offers->filter(function ($value, $key) use ($userId) {
            return $value['sender_user_id'] == $userId;
        });

        return $filtered->isNotEmpty() ? $filtered->first() : null;
    }
}