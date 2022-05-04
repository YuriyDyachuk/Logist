<?php

namespace App\Http\Controllers\Api\Orders;


use App\Models\Order\Order;
use App\Http\Controllers\Api\ApiController;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use League\Fractal\Manager;
use App\Enums\OrderStatus;

use App\Services\GoogleService;

use App\Transformers\ProgressTransformer;

class OrderController extends ApiController
{
    /**
     * @var OrderTransformer
     */
    protected $orderTransformer;

    /**
     * OrderController constructor.
     * @param Manager $fractal
     * @param OrderTransformer $orderTransformer
     */
    public function __construct(Manager $fractal, OrderTransformer $orderTransformer)
    {
        parent::__construct($fractal);

        $this->orderTransformer = $orderTransformer;
    }

	/**
	 * @OA\Get(
	 *      path="/api/v2/orders?status={status}",
	 *      operationId="getOrders",
	 *      tags={"Orders"},
	 *      summary="Get orders",
	 *      description="Returns orders",
	 *      @OA\Parameter(
	 *          name="status",
	 *          description="status: active (default) | completed | canceled",
	 *          required=false,
	 *          in="path",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="date_from",
	 *          description="date_from",
	 *          required=false,
	 *          in="path",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="date_to",
	 *          description="date_to",
	 *          required=false,
	 *          in="path",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Successful operation",
	 *       ),
	 *      @OA\Response(
	 *          response=404,
	 *          description="Not found",
	 *      )
	 *     )
	 */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $status = ($request->status === null) ? 'active' : $request->status;

        $orders_query = \Auth::user()
            ->getAttachedOrders()
            ->whereHas('status', function ($query) use ($status) {
                return $query->where('name', '=', $status)->where('type', '=', 'order');
            })
            ->with(['status', 'cargo', 'addresses', 'documents', 'client:id,name,phone', 'cargo.hazardClass', 'cargo.packageType', 'cargo.loadingType']);

        $date_from = ($request->date_from === null) ? null : $request->date_from;
        $date_to = ($request->date_to === null) ? null : $request->date_to;

        if($date_from && $date_to){
	        $date_from = Carbon::parse($date_from)->startOfDay();
	        $date_to = Carbon::parse($date_to)->endOfDay();
	        $orders_query->whereBetween('order_performers.created_at', [$date_from, $date_to]);
        }

	    $orders = $orders_query->get();

	    $orders->map(function ($order) {

		    $order['payment_type'] = ($order->payment_type) ? trans('all.order_'.$order->payment_type->name) : null;
		    $order['payment_terms'] = ($order->payment_terms) ? trans('all.order_'.$order->payment_terms->name) : null;

		    //TODO добавить перевод
		    $order['hazard_class'] = ($order->cargo->hazardClass) ? $order->cargo->hazardClass->name : null;
		    $order['pack_type'] = ($order->cargo->packageType) ? $order->cargo->packageType->name : null;
		    $order['loading_type'] = ($order->cargo->loadingType) ? $order->cargo->loadingType->name : null;

		    return $order;
	    });

        return $this->respondWithCollection($orders, $this->orderTransformer, false);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function create()
    {
        return $this->sendNotFoundResponse();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(Request $request)
    {
        return $this->sendNotFoundResponse();
    }


	/**
	 * @OA\Get(
	 *      path="/api/v2/orders/{id}",
	 *      operationId="getOrderShow",
	 *      tags={"Orders"},
	 *      summary="Get order by ID",
	 *      description="Returns order",
	 *      @OA\Parameter(
	 *          name="id",
	 *          description="order id",
	 *          required=true,
	 *          in="path",
	 *          @OA\Schema(
	 *              type="integer"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Successful operation",
	 *       ),
	 *      @OA\Response(
	 *          response=404,
	 *          description="Not found",
	 *      )
	 *     )
	 */
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Order::where('id', $id)
            ->with(['status', 'cargo', 'addresses', 'documents', 'client:id,name,phone', 'cargo.hazardClass', 'cargo.packageType', 'cargo.loadingType'])
            ->first();

        if (!$order)
            abort(404);

	    $order->payment_type = ($order->payment_type) ? trans('all.order_'.$order->payment_type->name) : null;
	    $order->payment_terms = ($order->payment_terms) ? trans('all.order_'.$order->payment_terms->name) : null;
        //TODO добавить перевод
        $order->hazard_class = ($order->cargo->hazardClass) ? $order->cargo->hazardClass->name : null;
        $order->pack_type = ($order->cargo->packageType) ? $order->cargo->packageType->name : null;
        $order->loading_type = ($order->cargo->loadingType) ? $order->cargo->loadingType->name : null;

	    if (($order->hasStatus(OrderStatus::PLANNING) || $order->hasStatus(OrderStatus::SEARCH) || $order->hasStatus(OrderStatus::ACTIVE))) {

		    $origins = $order->addresses->first()->lat.','.$order->addresses->first()->lng;
		    $destinations = $order->addresses->last()->lat.','.$order->addresses->last()->lng;

		    $val = (new GoogleService())->getDrivingDistanceTime($origins, $destinations);
		    $order->duration = $val['duration'];
	    }

        // TODO remove in future
//	    $order->progress = ProgressTransformer::transformLang($order->progress, 'ru');

        return $this->respondWithItem($order, $this->orderTransformer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        return $this->sendNotFoundResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function update(Request $request, $id)
    {
        return $this->sendNotFoundResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function destroy($id)
    {
        return $this->sendNotFoundResponse();
    }
}
