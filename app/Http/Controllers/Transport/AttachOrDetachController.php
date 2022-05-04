<?php

namespace App\Http\Controllers\Transport;


use App\Enums\TransportStatus;
use App\Models\Order\OrderPerformer;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transport\Transport;

class AttachOrDetachController extends Controller
{
    /**
     * @param Request $request
     * @param $orderId
     * @param $transportId
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(Request $request, $orderId, $transportId)
    {
        try {
            $user = \Auth::user();
            $oe = OrderPerformer::where('order_id', $orderId)->first();

            if ($oe->transport_id > 0) {
                Transport::query()->findOrFail($oe->transport_id)
                            ->update(['status_id' => Status::where('name', TransportStatus::FREE)->value('id')]);
            }

            $transport = Transport::query()->findOrFail($transportId);

            if ($user->id == $transport->user->id) {
                $partner_user = null;
            }else{
                $partner_user = $transport->user->id;
            }

            $oe->update(['transport_id' => $transportId, 'partner_id' => $partner_user]);

            Transport::query()->findOrFail($transportId)
                            ->update(['status_id' => Status::where('name', TransportStatus::FLIGHT)->value('id')]);

            if ($request->ajax())
                return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            if ($request->ajax())
                return response()->json(['status' => 'error', 'msg' => $e->getMessage()], 500);
        }
    }
}
