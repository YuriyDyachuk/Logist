<?php

namespace App\Services;

use App\Models\Order\OrderStatusHistory as OrderStatus;
use App\Models\Transport\TransportStatusHistory as TransportStatus;

class StatusService
{
    public function updateOrderStatusHistory($order_id, $status_id, $user_id = false){

        if(!$user_id){
            $user_id = \Auth::user()->id;
        }

        OrderStatus::create([
            'order_id'  => $order_id,
            'status_id' => $status_id,
            'user_id' => $user_id,
        ]);
    }

    public function updateTransportStatus($transport_id, $status_id, $user_id = false){

        if(!$user_id){
            $user_id = \Auth::user()->id;
        }

        TransportStatus::create([
            'transport_id'  => $transport_id,
            'status_id' => $status_id,
            'user_id' => $user_id,
        ]);
    }
}