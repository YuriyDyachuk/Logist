<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{

    /**
     * @param int $orderId
     * @param int $like
     */
    public function likeOrDislikeOrder($orderId, $like = 1)
    {
        if ($like) {
            Like::create([
                'user_id' => \Auth::user()->id,
                'order_id' => $orderId,
            ]);
        } else {
            Like::whereOrderId($orderId)->delete();
        }

        return response()->json(['status'=>'success', 'like' => $like]);
    }
}
