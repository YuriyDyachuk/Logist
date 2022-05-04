<?php

namespace App\Http\Controllers\Api\Orders;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Transformers\ProgressTransformer;
use App\Transformers\OrderTransformer;
use App\Services\OrderService;

class ProgressController extends Controller
{
	/**
	 * @OA\Get(
	 *      path="/api/v2/progress/{orderId}",
	 *      operationId="getProgress",
	 *      tags={"Orders"},
	 *      summary="Get progress info",
	 *      description="Returns progress info",
	 *      @OA\Response(
	 *          response=200,
	 *          description="Progress Info",
	 *         @OA\MediaType(
	 *             mediaType="application/json"
	 *          )
	 *       )
	 *     )
	 */
    public function getProgress($orderId){
        $order = Order::findOrFail($orderId);
//        $progress = ProgressTransformer::transformLang($order->progress);
        return response()->json(['result' => $order->progress]);
    }

    /**
     * @param $orderId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($orderId, Request $request)
    {
        $order = Order::findOrFail($orderId);

        $data = $request->get('data');

	    Log::info("Array Progress Order ID ".$orderId);
	    Log::info("Array Progress #1".json_encode($request->all()));

        if(is_string($data)) {
            $data = json_decode($data);
        }

        $old_data = $data;
        $data = ProgressTransformer::transform($data);

        $order->progress = $data;
        $order->save();

        if($this->checkIfAllCompleted($data)){

            // if all progress  is checked - complete order
            $service = new OrderService();
            $service->setOrder($order);
            $service->executeAction('completed', $request);

            if ($service->isFails()) {
	            Log::channel('innlogist')->info(json_encode($service->fails()));
//                return response()->json(['status' => 'ERROR', 'errors' => $service->fails()], 500);
            }

//            return response()->json(['result' => 'ok', 'msg' => 'order complete']);
        }

        return response()->json($old_data);
    }

    private function checkIfAllCompleted($data){
        $complete = true;

        foreach ($data as $item){
            if($item['completed'] == 0 || (isset($item['date_update']) && !preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1]) (0[1-9]|[0-2][0-3]|3[0-1])\:(0[0-9]|[1-5][0-9]|3[0-9])$/", $item['date_update']))){
                $complete = false;
            }
        }

        return $complete;
    }


    public function updatePosition($orderId, $position, Request $request){

        $order = Order::findOrFail($orderId);


        $transformer = new OrderTransformer();
        $transformed_order = $transformer->transform($order);
        $progress = $transformed_order['progress'];

        $data = $request->get('data');

        if(is_string($data))
            $data = json_decode($data);

        if(is_string($progress))
            $progress = json_decode($progress);



        foreach($progress as $key => $item){
            if(!isset($item['position']))
                continue;

            if($item['position'] == $position){
                $progress[$key] = $data;
                break;
            }

        }

        $old_data = $progress;
        $progress = ProgressTransformer::transform($progress);

        $order->update(['progress' => $progress, 'updated_at' => time()]);

        $updated_at = $order->updated_at->timestamp;
        $progress = $old_data;
        $user = \Auth::user();
        $driver    = $user->drivers()->first();
        $lang = $driver->locale;

        return response()->json(compact('progress', 'updated_at', 'lang'));

    }
}
