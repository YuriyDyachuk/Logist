<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPdf;

use App\Enums\OrderStatus;
use App\Enums\DocumentTypes;

use App\Models\Status;
use App\Models\Client;
use App\Models\Order\Order;
use App\Models\Order\OrderPerformer;
use App\Models\Order\Offer;
use App\Services\StatusService;
use App\Services\OfferService;

use App\Jobs\SendNewOrderNotification;

use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestOfferIncome;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    private $redirectTo = '/orders';

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();

        $company_id = $user->parent_id == 0 ? $user->id : $user->parent_id;

        $offer = Offer::whereOrderId($request->order)->whereCompanyId($company_id)->with('creator')->first();

        if($offer->amount_fact !== null){
            return response()->json(['status' => 'false', 'url' => '', 'msg' => trans('all.order_proposal_sent_other')]);
        }
        else {
            $offer->update(['amount_fact' => $request->get($request->type), 'user_id' => $user->id]);

            Notification::send($offer->creator, (new RequestOfferIncome($offer->order_id)));
        }

        return response()->json(['status' => 'success', 'url' => ''/*$this->redirectTo,*/]);
    }

    /**
     * Agree from client
     * @param int $orderId
     * @param int $executorId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function agree($orderId, $executorId)
    {
        \DB::beginTransaction();

        try {
            $order = Order::query()->findOrFail($orderId);

            $user =\Auth::user();

	        $executor = \App\Models\User::findOrFail($executorId);
	        $user_company_id = ($executor->parent_id != 0) ? $executor->parent_id : $executor->id;

            $offer = Offer::whereOrderId($orderId)->whereCompanyId($user_company_id)->first();

            $order_status = Status::getId(OrderStatus::PLANNING);

            $order->update([
                'current_status_id' => $order_status,
                'amount_fact' => $offer->amount_fact,
            ]);

	        OrderPerformer::whereOrderId($orderId)->update(['transport_id' => null]);

            OrderPerformer::create([
				'order_id'          => $orderId,
                'user_id'           => $executorId,
                'sender_user_id'    => $user->id,
                'payment_type_id'   => $offer->payment_type_id,
                'payment_term_id'   => $offer->payment_term_id,
                'vat'               => $offer->vat,
                'amount_plan'       => $offer->amount_fact,
            ]);

            OrderPerformer::whereUserId($order->user_id)->whereOrderId($order->id)->update(['amount_fact' => $offer->amount_fact]);

            (new StatusService)->updateOrderStatusHistory($order->id, $order_status);

            // TODO save in another table
            Offer::whereOrderId($orderId)->delete();

            if($user->isClient()){
	            $data  = ['latest_order' => $orderId, 'date' => date('d/m/Y', strtotime($order->created_at))];
	            Client::query()->updateOrCreate(
		            [
			            'user_id'   => $user_company_id,
			            'client_id' => $order->user_id,
		            ],
		            [
			            'data' => json_encode($data),
		            ]);
            }

            dispatch(new ProcessPdf($order->id, $user->id, DocumentTypes::REQUEST));

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            abort(404, $e->getMessage());
        }

        return redirect($this->redirectTo);
    }

    public function repeatRequest(Request $request, $orderId){

        $user = \Auth::user();

        $order = Order::whereId($orderId)->whereUserId($user->id)->first();

        if($order){

            $offerService = new OfferService($order);

            $suitableUsers = $offerService->searchSuitablePerformers();
            dispatch((new SendNewOrderNotification($order, $suitableUsers)));

            return redirect()->route('orders.show', ['id' => $orderId]);
        }

        return redirect()->route('orders');
    }
}
