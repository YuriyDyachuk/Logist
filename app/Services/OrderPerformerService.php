<?php

namespace App\Services;

use App\Models\Transport\Transport;
use App\Models\Status;
use App\Models\Order\OrderPerformer;
use App\Enums\TransportStatus;

class OrderPerformerService
{
    public function setPerformerTransport($order, $transport_id = null){
        $user = \Auth::user();

        $orderPerformer = OrderPerformer::whereUserId($user->id)->whereOrderId($order->id)->first();

        if($orderPerformer->transport_id && $transport_id === null){
            $transport = Transport::findOrFail($orderPerformer->transport_id);
            $transport->update(['status_id' => Status::where('name', TransportStatus::FREE)->value('id')]);

            $orderPerformer->update(['transport_id' => null]);
        }

        if($transport_id){
            $transport = Transport::findOrFail($transport_id);
            $transport->update(['status_id' => Status::where('name', TransportStatus::FLIGHT)->value('id')]);

            $orderPerformer->update(['transport_id' => $transport_id]);
        }
        
        return $orderPerformer;
    }

}