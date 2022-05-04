<?php

namespace App\Models\Traits\User;


trait UsersPartner
{
    public function getAcceptetPartnersWithKeys(){
        $partners_obj = $this->getAcceptetPartners();

        $partners = false;

        if($partners_obj->isNotEmpty()){
            $partners = $partners_obj->mapWithKeys(function ($item) {
                return [$item['id'] => $item];
            });
        }

        return $partners;
    }

    public function getPendingPartners(){
        return $this->getPartners(['status_id' => 1]);
    }

    public function getAcceptetPartners(){
        return $this->getPartners(['status_id' => 2]);
    }

    public function getDeclinedPartners(){
        return $this->getPartners(['status_id' => 3]);
    }

    public function getBlockedPartners(){
        return $this->getPartners(['status_id' => 4]);
    }

    public function getPartners($param = [])
    {
        $partners_user_one_query = $this->partnersOne();
        $partners_user_two_query = $this->partnersTwo();

        if(isset($param['status_id'])){
            $partners_user_one_query->where('status_id', $param['status_id']);
            $partners_user_two_query->where('status_id', $param['status_id']);
        }

        $partners_user_one = $partners_user_one_query->get();
        $partners_user_two = $partners_user_two_query->get();

        return $partners_user_one->merge($partners_user_two)->sortBy('id');
    }

    public function partnersOne(){
        return $this->belongsToMany('App\Models\User', 'partners', 'user_one_id', 'user_two_id')->withPivot('status_id', 'action_user_id');
    }

    public function partnersTwo(){
        return $this->belongsToMany('App\Models\User', 'partners', 'user_two_id', 'user_one_id')->withPivot('status_id', 'action_user_id');
    }
}