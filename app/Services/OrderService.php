<?php

namespace App\Services;


use App\Enums\OrderStatus;
use App\Enums\TransportStatus;
use App\Enums\UserRoleEnums;
use App\Enums\DocumentTypes;

use App\Jobs\SendNewOrderNotification;
use App\Jobs\ProcessPdf;

use App\Models\Client;
use App\Models\Order\Cargo;
use App\Models\Order\Order;
use App\Models\Order\OrderPerformer;
use App\Models\Relationships\OrderAddress;
use App\Models\RoleUser;
use App\Models\Status;
use App\Models\Transport\Transport;
use App\Models\User;
use App\Models\Transport\TransportDriver;
use App\Models\Transport\Testimonial;
use App\Models\Notification as NotificationModel;

use App\Notifications\CompletedOrder;
use App\Notifications\RejectOrder;
use App\Notifications\ReminderToLeaveTestimonial;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

use App\Mail\NewOrderEmail;
use Mail;

use Carbon\Carbon;

use App\Services\StatusService;
use App\Services\GcmService;
use App\Services\AnalyticService;
use App\Services\GeoService;
use App\Services\OfferService;
use App\Services\AmplitudeService;
use App\Services\PDFService;
use App\Services\RedisService;

use Illuminate\Support\Facades\Redis;

class OrderService
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->request = $request;

        \DB::beginTransaction();

        try {

            $route = ($this->request->route_polyline) ? $this->getDirections($this->request->route_polyline) : $this->getRoutePoints();

//            $user  = $this->request->user();
	        $user = auth()->user();
            $order = new Order;

            $order_status = Status::getId(OrderStatus::SEARCH);

            $order->id                   = $this->request->order_id;
            $order->user_id              = $user->id;
            $order->type                 = $this->request->type;
            $order->transport_cat_id     = $this->request->category;
            $order->register_trans_terms = $this->request->register_transport;
            $order->rating_terms         = $this->request->rating;
            $order->meta_data            = $this->request->get('meta_data', []);
            $order->amount_plan          = $this->request->recommend_price;
            $order->is_vat               = $this->request->is_vat;
            $order->currency             = $this->request->currency;
            $order->payment_term_id      = $this->request->payment_terms;
            $order->payment_type_id      = $this->request->payment_type;
            $order->current_status_id    = $order_status;
            $order->directions           = $route;
            $order->direction_waypoints  = $this->request->direction_waypoints;
            $order->comment              = $this->request->comment;

            $order->save();
            $this->order = $order;

            if ($user->isLogistic() || $user->isLogist()) {
                $order_status = Status::getId(OrderStatus::PLANNING);
//                $order->performers()->attach($user->id);
                $order->update(['current_status_id' => $order_status]);

                (new AmplitudeService())->simpleRequest('Take planning order');
            }

//            if ($user->isLogist()) {
//                $order_status = Status::getId(OrderStatus::PLANNING);
//                $order->performers()->attach($user->id);
//                $order->update(['current_status_id' => $order_status]);
//            }

            $this->updateOrderStatusHistory($this->order->id, $order_status);

            $order->addresses()->attach($this->getAddresses());
            $order->progress = $this->generateDefaultProgress($order->addresses()->get());

            $order->save();

            $client_id = $this->request->client;
            $client_user = null;

            if($client_id){
                $client = Client::where('client_id', $client_id)->first();
                $client_user = User::find($client_id);
                $order->Clients()->attach($client->id);

                Mail::to($client_user->email)->send(new NewOrderEmail($user, $client_user, $order));

                OrderPerformer::query()->create([
                    'order_id'          => $order->id,
                    'user_id'           => $client_id,
                    'sender_user_id'    => $client_id,
                    'payment_type_id'   => $this->request->payment_type,
                    'payment_term_id'   => $this->request->payment_terms,
                    'vat'               => $this->request->is_vat,
                    'amount_plan'       => $this->request->recommend_price,
                    'amount_fact'       => $this->request->recommend_price,
                    'debtdays'          => $this->request->debtdays,
                ]);

                //if client exists -> save templates to PDF
//                PDFService::storeAllDocumentToFile($order->id);
            }

            OrderPerformer::query()->create([
                'order_id'          => $order->id,
                'user_id'           => $user->id,
                'sender_user_id'    => $client_id ? $client_id : $user->id,
                'payment_type_id'   => $this->request->payment_type,
                'payment_term_id'   => $this->request->payment_terms,
                'vat'               => $this->request->is_vat,
                'amount_plan'       => $this->request->recommend_price,
                'debtdays'          => $this->request->debtdays,
            ]);

	        $order->loadingType()->attach($this->request->cargo_upload);

            Cargo::query()->create([
                'order_id'     => $order->id,
                'name'         => $this->request->cargo_name,
                'length'       => $this->request->cargo_length,
                'height'       => $this->request->cargo_height,
                'width'        => $this->request->cargo_width,
                'weight'       => $this->request->cargo_weight,
                'volume'       => $this->request->cargo_volume,
                'places'       => $this->request->cargo_places,
                'temperature'  => $this->request->cargo_temperature,
                'hazard_class_id' => $this->request->cargo_hazard,
//                'loading_type_id' => $this->request->cargo_upload,
                'loading_type_id' => is_array($this->request->cargo_upload) ? $this->request->cargo_upload[0] : $this->request->cargo_upload,
                'package_type_id' => $this->request->cargo_pack,
                'rolling_stock_type_id' => $this->request->cargo_rolling_stock
            ]);

//            if($client_user){ //created by company for client
//                dispatch(new ProcessPdf($order->id, $user->id));
//            }

            if ($user->isClient()) {  //created by client
                $offerService = new OfferService($this->order);

                $suitableUsers = $offerService->searchSuitablePerformers();
                dispatch((new SendNewOrderNotification($this->order, $suitableUsers)));
            }
            else {
	            dispatch(new ProcessPdf($order->id, $user->id, DocumentTypes::REQUEST));
            }

            $data_amplitude = [
                'cargo_name' => $this->request->cargo_name,
                'type_of_payment' => $this->request->payment_type,
                'type_of_conditions' => $this->request->payment_terms,
            ];

            (new AmplitudeService())->request('Create new order', $data_amplitude);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            $this->errors = ['line' => $e->getLine(), 'message' => $e->getMessage()];
        }

    }

    /**
     * @param string $name
     * @param Request $request
     */
    public function executeAction(string $name, Request $request)
    {
        $this->request = $request;
        $decorator     = strtolower($name) . 'Order';

        \DB::beginTransaction();
        try {
            $this->{$decorator}();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $this->errors = ['line' => $e->getLine(), 'message' => $e->getMessage()];
        }
    }

    /**
     * @return void
     */
    protected function activateOrder()
    {
        $this->order->load('performers');

        if(!$this->checkInProgress(['upload', 'download'])){
	        $this->errors = ['message' => trans('all.order_must_progress_upload_download')];
        }
        elseif ($id = $this->request->get('transportId', 0)) {
            $performer = $this->order->getPerformer();

            $orderPerformer = OrderPerformer::whereOrderId($this->order->id)->whereUserId($performer->user_id)->first();
            $transport_id = $orderPerformer->transport_id;
            $orderPerformer->update(['transport_id' => $id, 'amount_fact' => $orderPerformer->amount_plan]);

//            $this->order->performers()->updateExistingPivot($performer->id, ['transport_id' => $id]);

			// clear Redis transport info
	        RedisService::clearTransportInfo($id);

            $order_status = Status::whereName(OrderStatus::ACTIVE)->value('id');

            $this->order->update([
                'current_status_id' => $order_status,
            ]);

            $transport_status = Status::whereName(TransportStatus::FLIGHT)->value('id');
            $transport_status_free = Status::whereName(TransportStatus::FREE)->value('id');

            Transport::query()
                ->findOrFail($id)
                ->update(['status_id' => $transport_status]);

	        $this->orderSMSDriver($this->order, $id);

	        if($transport_id){
                Transport::query()
                    ->findOrFail($transport_id)
                    ->update(['status_id' => $transport_status_free]);
            }

            GcmService::sendOrderNotification(1, $id, $this->order->id);

            $this->updateOrderStatusHistory($this->order->id, $order_status);

            (new AmplitudeService())->simpleRequest('Activate order');

        } else {
            $this->errors = ['message' => trans('all.order_must_attached_transport')];
        }
    }

    private function checkInProgress($data): bool
    {
	    $progress_array = [];

		foreach ($data as $item){
		    $progress_array[$item] = false;
	    }

	    if($this->order->progress !== null && !empty($progress_array)){
			foreach ($this->order->progress as $progress){
				if(array_key_exists($progress['type'], $progress_array)){
					$progress_array[$progress['type']] = true;
				}
			}
	    }

	    if(!empty($progress_array)){
		    $progress_array_count = count($progress_array);
		    $result_count = 0;

			foreach ($progress_array as $key=>$item){
				if ($item === true) {$result_count++;}
			}

			return $progress_array_count == $result_count ? true : false;
	    }

	    return true;
    }

    /**
     * @return void
     */
    protected function rejectionOrder()
    {
        $user = $this->request->user();
        $this->order->load('performers');

        $performer = $this->order->getPerformer();

        $order_status = Status::whereName(OrderStatus::CANCELED)->value('id');

        $this->order->update([
            'current_status_id' => $order_status,
            'meta_data'         => serialize(['comment' => $this->request->get('comment')]),
        ]);

        $offerService = new OfferService($this->order);
        $offerService->deleteOffers();

        $this->updateOrderStatusHistory($this->order->id, $order_status);

        if ($user->id != $this->order->user_id) {
            $this->replication();

            Notification::send(
                $user = User::find($this->order->user_id),
                new RejectOrder($this->order, $user)
            );
        }

//        $performer = $this->order->performers->first();
        if ($performer->transport_id) {
	        $driver_id = TransportDriver::where('transport_id', $performer->transport_id)->pluck('user_id');
            $transport_status = Status::whereName(TransportStatus::FREE)->value('id');
            Transport::query()->findOrFail($performer->transport_id)->update(['status_id' => $transport_status, 'current_order_id' => null]);

            GcmService::sendOrderNotification(3, $driver_id, $this->order->id);
        }
    }

    /**
     * @return void
     */
    protected function rejectionoffersOrder()
    {
        $offerService = new OfferService($this->order);
        $offerService->deleteOffers();
    }

	/**
	 *
	 * @return void
	 */
	protected function rejectionexecuteofferOrder()
	{
		$this->order->load('performers');
		$performer = $this->order->getPerformer();

		$sender_user_id = $performer->sender_user_id;
		$current_user = auth()->user();

		if($performer->transport_id !== null){
			$transport_status = Status::whereName(TransportStatus::FREE)->value('id');
			Transport::query()->findOrFail($performer->transport_id)->update(['status_id' => $transport_status]);
		}

		OrderPerformer::whereOrderId($performer->order_id)->whereUserId($performer->user_id)->delete();

		Notification::send(
			$user = User::find($sender_user_id),
			new RejectOrder($this->order, $current_user)
		);

		if(User::getUserRoleName($sender_user_id) === UserRoleEnums::CLIENT){
			$order_status = Status::whereName(OrderStatus::SEARCH)->value('id');
			$this->order->update(['current_status_id' => $order_status]);

			// TODO send new offers
			$offerService = new OfferService($this->order);
			$suitableUsers = $offerService->searchSuitablePerformers($current_user->id);
			dispatch((new SendNewOrderNotification($this->order, $suitableUsers)));
		}
	}

    /**
     * @return void
     */
    protected function completedOrder()
    {
        $performer = $this->order->getPerformer();

        $user = auth()->user();

	    if($performer === null && $user->getTable() == 'transports'){
		    $performer = $this->order->getPerformer($user->user_id); // if driver complete order
	    }

	    $driver_id = TransportDriver::where('transport_id', $performer->transport_id)->pluck('user_id');

	    if($performer->transport_id == $user->id){ // if current user is driver
		    $user = User::findOrFail($driver_id)->first();
	    }

        (new AnalyticService())->updateStat($this->order);

	    (new AmplitudeService())->simpleRequest('Order completed');

        $order_status = Status::whereName(OrderStatus::COMPLETED)->value('id');
        $this->order->update(['current_status_id' => $order_status, 'completed_at' => Carbon::now()]);

        $this->updateOrderStatusHistory($this->order->id, $order_status, $user->id);

        $transport_status = Status::whereName(TransportStatus::FREE)->value('id');
        Transport::query()->findOrFail($performer->transport_id)->update(['status_id' => $transport_status]);

        OrderPerformer::find($performer->id)->update(['amount_fact' => $performer->amount_plan]);

        GeoService::geoOptimize($performer->order_id);

        GcmService::sendOrderNotification(4, $driver_id, $performer->order_id);

        $creator = User::find($this->order->user_id);

        if ($this->order->user_id != $user->id && $creator->isClient() === false) {
            Notification::send($creator, new CompletedOrder($this->order, $user));
        }

        // if creator is client
        if($creator->isClient()){
            Notification::send($creator, new ReminderToLeaveTestimonial($this->order));
        }

        try {
            // delete all redis data for this order
            $env = config('app.env');
            Redis::del($env.'transportid', $performer->transport_id);
            Redis::set($env.'transportid:orderid', $this->order->id);
        } catch (\Exception $e) {
            logger('Complete Order. Redis'.$e->getMessage());
        }

    }

    protected function planningOrder(){
        $order_status = Status::whereName(OrderStatus::PLANNING)->value('id');
        $this->order->update(['current_status_id' => $order_status, 'completed_at' => null]);

        $this->updateOrderStatusHistory($this->order->id, $order_status);
    }

    protected function testimonialOrder()
    {

        $performer = $this->order->performers->last();
        $driver_id = TransportDriver::where('transport_id', $performer->transport_id)->pluck('user_id');

        Testimonial::create(
            [
                'order_id'      => $this->order->id,
                'user_id'       => auth()->user()->id,
                'company_id'    => $performer->user_id,
                'transport_id'  => $performer->transport_id,
                'driver_id'     => $driver_id->first(),
                'comment'       => $this->request->comment,
                'rating'        => ($this->request->rating) ? $this->request->rating : null,
            ]);

        $notification = NotificationModel::whereType('App\Notifications\ReminderToLeaveTestimonial')->whereNotifiableId(auth()->user()->id)->whereNull('read_at')->where('data', 'like', '%'.$this->order->id.'%')->update(['read_at' => Carbon::now()]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model a new Order
     */
    protected function replication()
    {
        //the Order
        $newOrder                    = $this->order->replicate();
        $newOrder->current_status_id = Status::query()
            ->where('name', OrderStatus::SEARCH)
            ->value('id');
        $newOrder->meta_data         = array();
        $newOrder->save();

        //the Cargo
        $newCargo           = $this->order->cargo->replicate();
        $newCargo->order_id = $newOrder->id;
        $newCargo->save();

        //Addresses
        $addresses = OrderAddress::query()->where('order_id', $this->order->id)->get();

        foreach ($addresses as $address) {
            $newPivot           = $address->replicate();
            $newPivot->order_id = $newOrder->id;
            $newPivot->save();
        }

        $newOrder->progress = $this->generateDefaultProgress($this->order->addresses);
        $newOrder->save();

        return $newOrder;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return array
     */
    public function fails(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isFails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @param string $polyline
     * @param string $delimiter
     * @return array
     */
    public function getDirections(string $polyline, $delimiter = ':::')
    {
        $directions = [];
        $legs       = explode($delimiter, $polyline);

        foreach ($legs as $leg) {
            if (empty($leg)) continue;

            $path = GoogleService::polylineDecode($leg);
            $directions = array_merge($directions, $path);
        }

        return $directions;
    }

    private function getRoutePoints(){
        $points = $this->request->get('points');

        $coordinates = [];

        foreach ($points as $type => $addresses) {
            $address = \App\Models\Address::find($addresses[0]['address_id']);
            $coordinates[] = $address->lat.','.$address->lng;
        }
        return (new GoogleService())->getRoutePoints($coordinates[0], $coordinates[1]);
    }

    /**
     * @return array
     */
    protected function getAddresses()
    {
        $data   = [];
        $points = $this->request->get('points');

        foreach ($points as $type => $addresses) {
            foreach ($addresses as $address) {
                $date_from = str_replace("/", "-", $address['date_at']);

                $data[$address['address_id']] = [
                    'type'    => $type,
                    'date_at' => Carbon::parse($date_from),
                ];
            }
        }

        return $data;
    }

    protected function generateDefaultProgress(Collection $addresses)
    {
        $progress = array();
        $position = 0;

        //Accept step
        $progress[$position] = [
            'type'      => 'accepted',
            'name'      => trans('all.progress_accepted'),
            'address'   => "",
            'date_at'   => config('innlogist.progress_date_default'),
            'completed' => 0,
            'position'  => $position
        ];

        $position++;

        foreach ($addresses as $key => $address) {

            switch ($address->pivot->type) {
                case 'loading':
                    $progress[$position] = [
                        'type'  => 'download',
                        'name'  => trans('all.progress_' . $address->pivot->type),
                        'address' => $address->address,
                        'date_at' => $address->pivot->date_at,
                        'completed' => 0,
                        'position' => $position
                    ];

                    $position++;

                    $progress[$position] = [
                        'type'      => 'inway',
                        'name'      => trans('all.progress_to_flight'),
                        'address'   => "",
                        'date_at'   => config('innlogist.progress_date_default'),
                        'completed' => 0,
                        'position'  => $position
                    ];
                    $position++;
                    break;
                case 'unloading':
                    $progress[$position] = [
                        'type'  => 'upload',
                        'name'  => trans('all.progress_' . $address->pivot->type),
                        'address' => $address->address,
                        'date_at' => $address->pivot->date_at,
                        'completed' => 0,
                        'position' => $position
                    ];

                    $position++;

                    $progress[$position] = [
                        'type'      => 'delivered',
                        'name'      => trans('all.progress_delivered'),
                        'address'   => "",
                        'date_at'   => config('innlogist.progress_date_default'),
                        'completed' => 0,
                        'position'  => $position
                    ];
                    $position++;
                    break;
                default:
                    $type = $address->pivot->type;
            }
        }

        return $progress;
    }

//    /**
//     * @param $places
//     * @return array
//     */
//    public function refreshProgress($places)
//    {
//        $temp     = array();
//        $progress = array();
//
//        foreach ($places as $place) {
//            $temp['type']      = $place->type;
//            $temp['name']      = trans('all.progress_' . $place->type);
//            $temp['address']   = $place->address;
//            $temp['date']      = $data[$place->type . '_date'] ?? '---';
//            $temp['completed'] = 0;
//
//            array_push($progress, $temp);
//        }
//
//        return $progress;
//    }

    /**
     * Generates auto-increment value, then cancels the current transaction.
     *
     * @return int
     */
    public static function getOrderNumber()
    {
        \DB::beginTransaction();
        $order = Order::query()->create(['user_id' => 0]);
        \DB::rollback();

        return $order->id;
    }


	private function orderSMSDriver($order, $transport_id){
		$transport = Transport::query()->findOrFail($transport_id);
		$transport->load('drivers');
		$order->load('addresses');

		$driver_name = $transport->drivers->first()->name;
		$driver_phone = $transport->drivers->first()->phone;
		$order_id = $order->id;

		//first address
		$address_first = $order->addresses[0]['address'];
		//last address
		$amount = count($order->addresses);
		$address_last = $order->addresses[$amount-1]['address'];

		$msg = trans('all.new_order_sms_driver', ['name' => $driver_name, 'order' => $order_id])."\n".trans('all.loading').':'.$address_first."\n".trans('all.unloading').':'.$address_last;

            TwilioService::sendSMS($driver_phone, $msg);
	}

	private function updateOrderStatusHistory($order_id, $status_id, $user_id = false){
        (new StatusService)->updateOrderStatusHistory($order_id, $status_id, $user_id);
    }
}
