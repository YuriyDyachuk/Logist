<?php

namespace App\Http\Controllers;


use App\Enums\OrderStatus;
use App\Enums\TransportStatus;

use App\Models\Client;
use App\Models\Partner;
use App\Models\PartnerStatus;
use App\Models\Status;
use App\Models\Order\Order;
use App\Models\Order\Profitability;
use App\Models\Order\OrderPaymentType;
use App\Models\Order\OrderPaymentTerm;
use App\Models\Order\CargoLoadingType;
use App\Models\Order\CargoPackageType;
use App\Models\Order\CargoHazardClass;
use App\Models\Order\OrderPerformer;
use App\Models\Template;
use App\Models\Transport\Transport;
use App\Models\Transport\Category;
use App\Models\Transport\RollingStockType;
use App\Models\User;
use App\Models\Document\DocumentForms;
use App\Models\Order\Offer;

use App\Notifications\ApprovedOrderPartner;
use App\Notifications\RequestOrderPartner;

use App\Search\Order\OrderSearch;
use App\Services\OrderService;
use App\Services\TransportService;
use App\Services\GoogleService;
use App\Services\OfferService;
use App\Services\OrderPerformerService;

use App\Http\Requests\OrderStore;
use App\Http\Requests\OrderUpdate;

use App\Transformers\ProgressTransformer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Traits\Macroable;

use Carbon\Carbon;

use DB;

class OrderController extends Controller
{
    use Macroable;

    protected $order;
    protected $filters;
    protected $specializations;
    protected $redirectTo = 'orders';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
//        if (!app_has_access('orders.all'))
//            return redirect()->to('/profile');

        $user = \Auth::user();
        $type = $request->input('filters.type') == 'requests'
            ? 'requests'
            : 'orders';

        // Adds filters
        $this->filters = $request->get('filters');
	    $this->filters[$type] = true;

        $partners = $user->getAcceptetPartnersWithKeys();
        $payment_types = OrderPaymentType::getTypes();
        $payment_terms = OrderPaymentTerm::getTerms();

        if ($type == 'requests') {

            $this->filters['relationships_request'] = true;//Eager Loading
            $this->filters['delay'] = true;
            $this->filters['without_own'] = true;
            $this->filters['has_offers'] = true;

            $filters = $this->filters;

            $orders = OrderSearch::apply($this->filters)->latest()->paginate(10);

        } else {
            $this->filters['relationships'] = true;//Eager Loading
            $filters = $this->filters;

            // Get orders
            $orders = OrderSearch::apply($this->filters)->latest()->paginate(10);
        }

        // Get unread notifications
        $notifications = $user->unreadNotifications->reduce(function ($carry, $item) {
                if ($item->type == 'App\Notifications\NewRequest')
                    $carry['order_' . $item->data['order_id']] = $item->id;

                return $carry;
            }) ?? array();


        if ($request->ajax()) {
            $view = view('orders.partials.index.list-orders', compact('user', 'orders', 'type', 'filters', 'notifications', 'partners', 'payment_types', 'payment_terms'))->render();

            return response()->json(['status' => 'ok', 'type' => $type, 'html' => $view]);
        }

        $statuses = Status::getOrders();
        $specializations = SpecializationController::get();

        return view('orders.index', compact('user', 'type', 'filters', 'orders', 'statuses', 'specializations', 'notifications', 'partners', 'payment_types', 'payment_terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if (!app_has_access('orders.all'))
//            abort(404);

        $user = \Auth::user();

        $user_company = $user->parent_id;

        if ($user->isActivatedUser()) {
            $orderId = OrderService::getOrderNumber();
            $categories = Category::getCategory();
            $templates = $user->templates()->get();
//            $clients = $user->clients()->get();

            $payment_type = OrderPaymentType::all();
            $payment_term = OrderPaymentTerm::all();
            $cargo_loading_types = CargoLoadingType::all();
            $cargo_package_types = CargoPackageType::all();
            $cargo_hazard_classes = CargoHazardClass::all();
            $cargo_rolling_stock_types = RollingStockType::where('parent_id', '!=', 0)->get();

            $clients_obj = Client::whereIn('user_id', [$user_company, $user->id])->with('user')->orderBy('created_at', 'asc')->get();
            $clients = $clients_obj->map(function ($item, $key) {
                return $item['user'];
            });

            return view('orders.create', compact('orderId', 'categories', 'templates', 'clients', 'payment_type', 'payment_term', 'cargo_loading_types', 'cargo_package_types', 'cargo_rolling_stock_types', 'cargo_hazard_classes', 'user' ));
        }

        return redirect('/setting');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStore $request)
    {
//        if (!app_has_access('orders.all'))
//            abort(404);

        $user = $request->user();
        $orderService = new OrderService();
        $orderService->store($request);

        if ($orderService->isFails()) {
            return response()->json(['status' => 'ERROR', 'errors' => $orderService->fails()], 400);
        }

        $order = $orderService->getOrder();
        $commission = 0;
        if ($request->has('recommend_price')) {
            if ($user->getRoleName() === \App\Enums\UserRoleEnums::LOGIST) {
                $commision_rate = isset($user->meta_data['rate']) ? $user->meta_data['rate'] : -1;
                $commision_percent = isset($user->meta_data['percent']) ? $user->meta_data['percent'] : 0;
                if ($commision_rate != -1 && $commision_percent != 0) {
                    $commission = $commision_rate + $request->recommend_price * ($commision_percent / 100);
                }
                elseif ($commision_rate != -1) {
                    $commission = $commision_rate;
                } else {
                    $commission = $request->recommend_price * ($commision_percent / 100);
                }
            }
            Profitability::updateOrCreate(
                ['order_id' => $order->id,
                'amount' => $request->recommend_price,
                'commission' => $commission,
                ]);
        }

        // Save the order as a template
        if ($request->has('save_as_template')) {
            Template::query()->create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'name' => $request->get('save_as_template'),
            ]);
        }

        $redirectTo = $user->isLogistic()
            ? url("order/{$order->id}")
            : $this->redirectTo;

        return response()->json(['status' => 'OK', 'redirectTo' => $redirectTo]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateOrRejection(Request $request)
    {
        $order = Order::query()->findOrFail($request->get('orderId'));
        $action = $request->get('action');
        $redirectTo = ($action == 'activate')
            ? route('orders.show', $order->id)
            : route('orders');

        $service = new OrderService();
        $service->setOrder($order);
        $service->executeAction($action, $request);

        if ($request->ajax() && !$request->has('notificationId')) {

            if ($service->isFails()) {
                return response()->json(['status' => 'ERROR', 'errors' => $service->fails()], 500);
            }

            return response()->json(['status' => 'OK', 'redirectTo' => $redirectTo]);
        } else {

            $notification = auth()->user()->notifications()->find($request->notificationId);
            if($notification) {
                $notification->markAsRead();
            }
//            return redirect()->back();
            return response()->json(['status' => 'OK']);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show($id)
    {
//	    dispatch(new \App\Jobs\ProcessPdf($id, auth()->id()));

//        if (!app_has_access('orders.all'))
//            abort(404);
        // access for logistic, logist, client

        $order = Order::query()
            ->where('id', $id)
            ->with(['addresses', 'offers', 'performers', 'documents', 'suitablePerformers', 'category', 'payment_type', 'payment_term', 'geo', 'cargo.hazardClass', 'cargo.packageType', 'cargo.loadingType', 'cargo.rollingStockType','transports', 'history.status'])
            ->first();

        if (!$order) {
            abort(404, 'Not found');
        }

        $this->authorize('view', $order);

        $user = \Auth::user();

        $user_company = $user;

        if ($user->isLogist()) {
            $user_company = User::find($user->parent_id);
        }

        $clients = $user->clients()->get();
        $userIsLogistic = $user_company->isLogistic();

        $data = $this->transportQuery($user_company, $order, $userIsLogistic);

        $transports = $data['transports'];
        $attachedTrans = $data['attachedTrans'];

        $transports_partner = collect();

        $partners = $user_company->getAcceptetPartners();

        $order_to_partner = ($order->getPerformerSender() && Partner::isPartnerAccepted($order->getPerformerSender()->user_id, $user_company->id)) ?  true : false;
	    $order_to_partner_json = json_encode($order_to_partner, true);

        $order_from_partner = ($order->getPerformer() && Partner::isPartnerAccepted($order->getPerformer()->sender_user_id, $user_company->id)) ?  true : false;
	    $order_from_partner_json = json_encode($order_from_partner, true);

        $order_from_client = ($order->isOrderFromClient() !== false) ? true : false;

	    $offers_sent = $order->getOfferSender() ? true : false;
	    $offers_sent_json = json_encode($offers_sent, true);

	    $transport_partner = null;
	    if($order->getPerformerSender() && $order->getPerformerSender()->transport_id !== null){
		    $transport_id = $order->getPerformerSender()->transport_id;
		    $transport_partner = Transport::query()->findOrFail($transport_id);
		    $transport_partner->load('drivers');
        }

	    $client_id = ($order->Clients()->count() > 0) ? $order->Clients()->first()->client_id : 0;

        if (($order->hasStatus(OrderStatus::PLANNING) || $order->hasStatus(OrderStatus::SEARCH) || $order->hasStatus(OrderStatus::ACTIVE))) {
            $partners->load('transports');

            $transports_partner = $partners->filter(function ($value, $key) {
                if($value['transports']->isNotEmpty()){
                    $isExist = false;
                    foreach ($value['transports'] as $transport){
                        if($isExist === true) continue;

                        if($transport->status_id === 7){
                            $isExist = true;
                        }
                    }
                    if($isExist){
                        return $value;
                    }
                }
            });

            $origins = $order->addresses->first()->lat.','.$order->addresses->first()->lng;
            $destinations = $order->addresses->last()->lat.','.$order->addresses->last()->lng;

            $val = (new GoogleService())->getDrivingDistanceTime($origins, $destinations);
            $order->duration = isset($val['duration']) ? $val['duration'] : '';

        }

        $templates = DocumentForms::select('id', 'slug')->get();
        $payment_type = OrderPaymentType::all();
        $payment_term = OrderPaymentTerm::all();

        // update lang
	    $order->progress = ProgressTransformer::transformLang($order->progress);

        return view('orders.show', compact(
            'templates',
            'order_from_partner',
	        'order_from_partner_json',
            'order_from_client',
            'offers_sent',
            'offers_sent_json',
            'order_to_partner',
            'order_to_partner_json',
            'user',
            'order',
            'transports',
            'transport_partner',
            'transports_partner',
            'partners',
            'attachedTrans',
            'userIsLogistic',
            'clients',
            'client_id',
            'payment_type',
            'payment_term'));
    }

    public function transportQuery($user, $order, $userIsLogistic, $partner = 0)
    {
        $transports = [];
        $attachedTrans = [];

        $transportService = new TransportService($user);
        $performer = $order->getPerformer();
        $performer_sender = $order->getPerformerSender();
        $offer = $order->getOffer();
        $offer_sender = $order->getOfferSender();

        $can_update_transport =  ($performer_sender === null && $offer_sender === null && $offer === null) ? true : false;

        $order->performer = $performer;

        if ($performer && $performer->transport_id && $can_update_transport === true) {

            $transport = Transport::query()->find($performer->transport_id);

            if ($transport) {
                $performer->_transport = $transportService->transform($transport);
            }
        }

        if ($order->hasStatus(OrderStatus::PLANNING) && $userIsLogistic && $can_update_transport === true) {
            $_transports = $transportService->findSuitable($order);
            if (!$performer->_transport && $_transports->isNotEmpty()) {

                OrderPerformer::whereOrderId($order->id)->whereUserId($user->id)->update(['transport_id' => $_transports->first()->id]);

                $_transports->first()->update(['status_id' => Status::where('name', TransportStatus::FLIGHT)->value('id')]);

                $performer->_transport = $transportService->transform($_transports->first());
            }

            $transports = $transportService->transforms($_transports);

            if ($performer->_transport && !$transports->contains('id', $performer->_transport->id)) {
                $transports->add($performer->_transport);
            }


            //For Vue.js
            $attachedTrans = $performer->_transport
                ? json_encode($performer->_transport->toArray(), true)
                : json_encode([]);
            if (!$partner) {
                $transports = json_encode($transports->toArray(), true);
            } else {
                $transports = $transports->toArray();
            }
        }

        if($order->hasStatus(OrderStatus::ACTIVE) && $performer && $performer->transport_id){

			$status_flight = Status::where('name', TransportStatus::FLIGHT)->value('id');

			if($order->transports->first()->status_id != $status_flight){
		        $order->transports->first()->update(['status_id' => $status_flight]);
	        }
        }

        if(empty($transports) && empty($attachedTrans)){
            $transports = json_encode($transports, true);
            $attachedTrans = json_encode($attachedTrans, true);
        }

        return ['transports' => $transports, 'attachedTrans' => $attachedTrans];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdate $request, $id)
    {
//        if (!app_has_access('orders.all'))
//            abort(404);

        $order = Order::query()->findOrFail($id);

        if ($request->has('recommend_price') || $request->has('commission')) {
	        $profitability = $request->all();
	        $profitability['amount'] = floatval($request->recommend_price);
            Profitability::updateOrCreate(
                ['order_id' => $order->id],
	            $profitability
            );
        }

        $data = [];

        if ($request->has('recommend_price')) {
            $data['amount_plan'] = floatval($request->recommend_price);
	        $debtdays = $order->getPerformer();
	        $debtdays->update(['amount_plan' => $data['amount_plan']]);
        }

        if ($request->has('comment')) {
            $data['comment'] = $request->comment;
        }
        if ($request->has('debtdays')) {
            $debtdays = $order->getPerformer();
            $debtdays->update(['debtdays' => $request->debtdays]);
        }

        if(!empty($data)){
            $order->update($data);
        }

        if($request->has('cargo')){
//            logger(print_r($request->cargo, true));

            $cargo = \App\Models\Order\Cargo::whereOrderId($order->id)->first();
            $cargo->update([
                'name'          => $request->cargo['cargo_name'],
                'places'        => $request->cargo['cargo_places'],
                'length'        => $request->cargo['cargo_length'],
                'height'        => $request->cargo['cargo_height'],
                'width'         => $request->cargo['cargo_width'],
                'weight'        => (float)$request->cargo['cargo_weight'] * 1000, // to kg
                'volume'        => $request->cargo['cargo_volume'],
                'temperature'   => $request->cargo['cargo_temperature'],
                'hazard_class_id' => $request->cargo['cargo_hazard'],
                'loading_type_id' => $request->cargo['cargo_package_type'],
                'rolling_stock_type_id' => $request->cargo['cargo_rolling_stock_type'],
                ]);

	        $order->loadingType()->sync($request->cargo_loading_type);
        }

        $partners = [];
        $partners_request = false;

        if($request->partners != ''){
            $partners = explode (',', $request->partners);
            $partners_request = true;
        }

        if (!empty($partners)) {

            $order->fresh();

            $user = \Auth::user();

            $offerService = new OfferService($order);

            foreach($partners as $partner_id){
                $partner = User::find($partner_id);
                Notification::send($partner, new RequestOrderPartner($user));
                $offerService->storeUserOffer($partner->id, null, $request);
            }

            $orderPerformer = new OrderPerformerService();
            $orderPerformer->setPerformerTransport($order);
        }

        $estimated_arrival = false;

        if ($request->has('points')) {
            $points = $request->get('points');
            $adresses = $order->addresses()->get()->pluck('id')->toArray();
            $order->addresses()->detach($adresses);

            foreach ($points as $type => $items) {

                foreach ($items as $key => $point) {

                    $points_array[] = $point['address_id'];

                    $date_from = str_replace("/", "-", $point["date_at"]);

                    $order->addresses()->attach($point['address_id'],
                        [
                            'type' => $type,
                            'date_at' => Carbon::parse($date_from)
                        ]
                    );
                }

            }
            $orderService = new OrderService();

            $order->directions = $orderService->getDirections($request->get('route_polyline'));
            $order->direction_waypoints  = $request->get('direction_waypoints', '[]');
            $order->save();

            if (($order->hasStatus(OrderStatus::PLANNING) || $order->hasStatus(OrderStatus::SEARCH) || $order->hasStatus(OrderStatus::ACTIVE))) {

                $origins = $order->addresses->first()->lat.','.$order->addresses->first()->lng;
                $destinations = $order->addresses->last()->lat.','.$order->addresses->last()->lng;

                $val = (new GoogleService())->getDrivingDistanceTime($origins, $destinations);

                $date_first = Carbon::parse($order->addresses->first()->pivot->date_at)->timestamp;
                $estimated_arrival = Carbon::createFromTimestamp($date_first+$val['duration'])->format('d/m/Y H:i');
            }
        }

        return response()->json(['status' => 'success', 'estimated_arrival' => $estimated_arrival, 'partners_request' => $partners_request]);
    }

    public function partnerApproved(Request $request, $id, $executor)
    {

        $user = \Auth::user();
        $order = Order::query()->findOrFail($id);
        $partner_user = User::query()->findOrFail($executor);

        $is_partner = Partner::isPartner($user->id, $partner_user->id, PartnerStatus::getId(PartnerStatus::ACCEPTED));

        if ($is_partner) {

            $offer = Offer::whereOrderId($order->id)->whereUserId($partner_user->id)->first();

            OrderPerformer::create([
                'order_id'          => $order->id,
                'user_id'           => $partner_user->id,
                'sender_user_id'    => $user->id,
                'payment_type_id'   => $offer->payment_type_id,
                'payment_term_id'   => $offer->payment_term_id,
                'vat'               => $offer->vat,
                'amount_plan'       => $offer->amount_fact,
                'amount_fact'       => $offer->amount_fact,
            ]);

            $orderPerformer = new OrderPerformerService();
            $orderPerformer = $orderPerformer->setPerformerTransport($order);

            $orderPerformer->update(['amount_fact' => $offer->amount_fact]);

            Notification::send($partner_user, new ApprovedOrderPartner($user, $order));

            // TODO save in another table
            $offerService = new OfferService($order);
            $offerService->deleteOffers();
        }

        return redirect()->back();
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
