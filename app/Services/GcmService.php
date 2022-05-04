<?php

namespace App\Services;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Models\UserDevice;
use App\Models\User;

class GcmService
{

    static private $title = 'inn-logist';

    public static function sendNotification($id, $msg){

        $device = UserDevice::where('user_id',$id)->first();

        if ($device){
            $device=$device->toArray();
            $tokens[] = $device['gcm_id'];

            $notificationBuilder = new PayloadNotificationBuilder();
            $notificationBuilder->setTitle(self::$title)
                ->setBody(is_array($msg) ? $msg['message'] : '')
                ->setSound('default');

            $notification = $notificationBuilder->build();

            $data = null;
            if(is_array($msg)) {
                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData( $msg );
                $data = $dataBuilder->build();
            }


            $downstreamResponse = FCM::sendTo($tokens, null, $notification, $data);
//            $downstreamResponse = FCM::sendTo($tokens, null, null, $data);

            $r1 = $downstreamResponse->numberSuccess();
            $r2 = $downstreamResponse->numberFailure();
            $r3 = $downstreamResponse->numberModification();

//                Log::useFiles(public_path().'/logs/log-push-'.date('Y-m-d').'.txt');
//                if ($order){
//                    Log::info('New PUSH: '.print_r($order->id, true).' -------- '.print_r($downstreamResponse, true));
//                }
//                else {
//                    Log::info('New PUSH: no order -------- '.print_r($downstreamResponse, true));
//                }

            return $downstreamResponse;
        }

        return false;
    }

    public static function buildMessage($msg,$object,$action='unknown')
    {
        return([
            'action'=>$action,
            'message'=>$msg,
            'object'=>$object,
        ]);
    }

    public static function buildActionForOrder($type, $order_id=false)
    {
        switch ($type)
        {
            case 1:
                return self::buildMessage('new order',$order_id,'neworder');
                break;
            case 2:
                return self::buildMessage('update order',$order_id,'updateorder');
                break;
            case 3:
                return self::buildMessage('cancel order',$order_id,'cancelorder');
                break;
            case 4:
                return self::buildMessage('complete order',$order_id,'completeorder');
                break;
            case 5:
                return self::buildMessage('order progress update',$order_id,'orderprogressupdate');
                break;
        }
    }

    public static function sendOrderNotification($type, $user_id, $order_id){
        $msg = self::buildActionForOrder($type, $order_id);
        self::sendNotification($user_id, $msg);
    }
}