<?php

namespace App\Models\Traits\Order;

trait OrderPerformer
{

	/**
	 * Get order performer (logistic company, logist)
	 *
	 * @param null $userId
	 */
    public function getPerformer($userId = null){
	    $userParentId = null;
        if(is_null($userId)){
			$user = auth()->user();
            $userId = $user->id;

            if($user->getTable() != 'transports'){
	            $userParentId = $user->isAdmin() ? $user->parent_id : null;
            }
        }

        $filtered = $this->performers->filter(function ($value, $key) use ($userId, $userParentId) {
            return ($value['user_id'] == $userId || $value['executor']['parent_id'] == $userId || $value['user_id'] == $userParentId);
        });

        return $filtered->isNotEmpty() ? $filtered->first() : null;
    }

    public function getPerformerSender($userId = null){
	    $userParentId = null;
        if(is_null($userId)){
	        $user = auth()->user();
	        $userId = $user->id;
	        $userParentId = $user->isAdmin() ? $user->parent_id : null;
        }

        $filtered = $this->performers->filter(function ($value, $key) use ($userId, $userParentId) {
            return ($value['sender_user_id'] == $userId && $value['user_id'] != $userId) ||
                   ($value['sender_user_id'] == $userParentId && $value['user_id'] != $userParentId);
        });

        return $filtered->isNotEmpty() ? $filtered->first() : null;
    }

    public function getPerformerTransport($userId = null){
	    if(is_null($userId)){
		    $user = auth()->user();
		    $userId = $user->id;
	    }

	    $filtered = $this->performers->filter(function ($value, $key) use ($userId) {
		    return $value['transport_id'] == $userId;
	    });

	    return $filtered->isNotEmpty() ? $filtered->first() : null;
    }
}