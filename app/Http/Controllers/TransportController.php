<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use App\Http\Requests\TransportUpdateAjax;

use App\Enums\OrderStatus;
use App\Enums\TransportStatus;
use App\Enums\UserRoleEnums;
use App\Models\Document\Document;
use App\Models\Image;
use App\Models\Order\OrderPerformer;
use App\Models\Partner;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Status;
use App\Models\Transport\TransportKey as Password;
use App\Models\Transport\Category;
use App\Models\Transport\RollingStockType;
use App\Models\Transport\Transport;
use App\Search\Transport\TransportSearch;
use App\Http\Requests\TransportStore;
use App\Http\Requests\TransportUpdate;
use App\Http\Requests\StoreOwnTransport;

use App\Services\GlobusService;
use App\Services\TransportService;
use App\Services\TwilioService;
use App\Services\DocumentService;
use App\Services\LogisticService;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{
    protected $filters = [];
    protected $transport;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
//        if(!app_has_access('transport.all'))
//            abort(404);

//        $auth_user = \Auth::user();

//        $user_company = null;

//	    $logists_array = [];
//
//	    $logists = null;
//
//        if ($auth_user->isLogistic()) {
//	        $logists = User::where('parent_id', $auth_user->id)->pluck('id');
//        }
//
//        if($auth_user->isLogist()){
//	        $userId = $auth_user->parent_id;
//	        $logists = User::where(function($q) use($userId) {
//		        $q->where('parent_id', $userId)
//		          ->orWhere('id', $userId);
//	        })->pluck('id');
//        }
//
//	    if($logists) {
//		    $logists_array = $logists->toArray();
//	    }
//
//	    $user_array = array_merge([$auth_user->id], $logists_array);

	    $user_array = LogisticService::getLogistsArray();

        $partner_transport = 0;
        // SET FILTERS
        $_filters         = $request->get('filters', []);
//        $_filters['user'] = $user_company ? $user_company->id : $auth_user->id;
        $_filters['user'] = $user_array;

        // Default
        if (!key_exists('type', $_filters) || empty($_filters['type'])) {
            $_filters['type'] = 'auto';
        }
        $filters = array_filter($_filters, function ($item) {
            return $item != null;
        });

        $filters['with_order'] = [Status::getId(OrderStatus::PLANNING), Status::getId(OrderStatus::ACTIVE)];
        $filters['transport_relationships'] = true;

        $transports = TransportSearch::apply($filters)->with('rollingStockType')->latest()->paginate(15);

        $statuses_all = Status::getTransports();

        $statuses = $statuses_all->whereIn('name', [TransportStatus::FREE, TransportStatus::REPAIR]);

        $statuses_all = $statuses_all->mapWithKeys(function ($item) {
            return [$item['id'] => $item];
        });

        $statuses_name = $statuses_all->mapWithKeys(function ($item) {
            return [$item['name'] => $item];
        });

        $category = Category::getAllWithKey();
        $rollingStockType = RollingStockType::getAllWithKey();

        foreach ($transports as $transport) {
            $transport->status_name   = (isset($statuses_all[$transport->status_id])) ? $statuses_all[$transport->status_id]->name : TransportStatus::INACTIVE;
            $transport->category_name = (isset($category[$transport->category_id])) ? $category[$transport->category_id]->name : 0;
            $transport->password      = TransportService::decodePassword($transport->id);
            $transport->isTrailer     = $transport->isTrailer();
            $transport->truck         = null;
            $transport->trailer       = null;

            if ($transport->isTrailer) {
                if ($truck = $transport->attachedTruck()->first()) {
                    $transport->truck   = $truck;
                    $transport->_driver = $transport->truck->drivers()->first();
//                    $transport->status_name   = Status::getName($truck->status_id);
                    $transport->status_name   = (isset($statuses_all[$truck->status_id])) ? $statuses_all[$truck->status_id]->name : TransportStatus::INACTIVE;;
                } else {
                    $transport->status_name   = TransportStatus::INACTIVE;
                }
//                $transport->rolling_stock_name = RollingStockType::getName($transport->rolling_stock_type_id);
                $transport->rolling_stock_name = isset($rollingStockType[$transport->rolling_stock_type_id]) ? $rollingStockType[$transport->rolling_stock_type_id]->name : '';
//                $transport->rolling_stock_name = $rollingStockType[$transport->rolling_stock_type_id]->name;
            } else {
                $active_order   = false;
                $order          = $transport->getAttachedOrders();

                if($order) {
                    $order_statuses = $order->whereIn('current_status_id', [1, 4, 5])->get();
                    if (count($order_statuses) > 0) {
                        $active_order = true;
                    }
                }

                /* изменяем статус транспорта если есть\нету активного заказа */
                if(!$active_order && $transport->status_name == TransportStatus::FLIGHT){

//                    $status = Status::getId(TransportStatus::FREE);
                    $status = $statuses_name[TransportStatus::FREE];
                    Transport::find($transport->id)->update(['status_id' => $status->id]);
//                    $transport->status_name   = Status::getName($status);
                    $transport->status_name   = $status->name;

                } elseif($active_order && $transport->status_name == TransportStatus::FREE){

//                    $status = Status::getId(TransportStatus::FLIGHT);
                    $status = $statuses_name[TransportStatus::FLIGHT];
                    Transport::find($transport->id)->update(['status_id' => $status->id]);
//                    $transport->status_name   = Status::getName($status);
                    $transport->status_name   = $status->name;
                } elseif($active_order && $transport->status_name == TransportStatus::FLIGHT && $transport->current_order_id != $order->first()->id){
	                Transport::find($transport->id)->update(['current_order_id' => $order->first()->id]);
                }

                $transport->_driver = $transport->drivers()->first();
                if ($trailer = $transport->attachedTrailer()->first()) {
                    $transport->trailer                       = $trailer;
//                    $transport->trailer['rolling_stock_name'] = RollingStockType::getName($transport->trailer['rolling_stock_type_id']);
//                    $transport->trailer['rolling_stock_name'] = $rollingStockType[$transport->trailer['rolling_stock_type_id']]->name;
                    $transport->trailer['rolling_stock_name'] = isset($rollingStockType[$transport->trailer['rolling_stock_type_id']]) ? $rollingStockType[$transport->trailer['rolling_stock_type_id']]->name : '';
                }
            }

            $transport->status_class  = $this->getStyleForStatus($transport->status_name);
        }

        if ($request->ajax()) {
            $view = view('transport.partials.list-transports', compact('transports', 'partner_transport', 'filters', 'statuses'))->render();

            return response()->json(['status' => 'success', 'html' => $view]);
        }

//        $category = Category::getCategory();
        $types    = Category::getType(Category::whereName('automobile')->value('id'))->toArray();

        $globus = new GlobusService();
        $gps_receive = collect($globus->receive());

        return view('transport.index', compact('transports', 'partner_transport', 'gps_receive', 'category', 'types', 'filters', 'statuses'));
    }

    public function transportMod($transports_mod)
    {
        $transports = $transports_mod;

        foreach ($transports as $transport) {
            $transport->status_name   = Status::getName($transport->status_id);
            $transport->category_name = Category::getName($transport->category_id);
            $transport->password      = TransportService::decodePassword($transport->id);
            $transport->isTrailer     = $transport->isTrailer();
            $transport->truck         = null;
            $transport->trailer       = null;

            if ($transport->isTrailer) {
                if ($truck = $transport->attachedTruck()->first()) {
                    $transport->truck   = $truck;
                    $transport->_driver = $transport->truck->drivers()->first();
                    $transport->status_name   = Status::getName($truck->status_id);
                } else {
                    $transport->status_name   = TransportStatus::INACTIVE;
                }
                $transport->rolling_stock_name = RollingStockType::getName($transport->rolling_stock_type_id);
            } else {
                $active_order   = false;
                $order          = $transport->getAttachedOrders();

//                if($order) {
//                    $status = $order->status()->first();
//
//                    if($status) {
//                        if($status->name != OrderStatus::CANCELED && $status->name != OrderStatus::COMPLETED)
//                            $active_order = true;
//                    }
//                }

                if($order) {
                    $order_statuses = $order->whereIn('current_status_id', [1, 4, 5])->get();
                    if (count($order_statuses) > 0) {
                        $active_order = true;
                    }
                }

                /* изменяем статус транспорта если есть\нету активного заказа */
                if(!$active_order && $transport->status_name == TransportStatus::FLIGHT){

                    $status = Status::getId(TransportStatus::FREE);
                    Transport::find($transport->id)->update(['status_id' => $status]);
                    $transport->status_name   = Status::getName($status);

                } elseif($active_order && $transport->status_name == TransportStatus::FREE){

                    $status = Status::getId(TransportStatus::FLIGHT);
                    Transport::find($transport->id)->update(['status_id' => $status]);
                    $transport->status_name   = Status::getName($status);
                }

                $transport->_driver = $transport->drivers()->first();
                if ($trailer = $transport->attachedTrailer()->first()) {
                    $transport->trailer                       = $trailer;
                    $transport->trailer['rolling_stock_name'] = RollingStockType::getName($transport->trailer['rolling_stock_type_id']);
                }
            }

            $transport->status_class  = $this->getStyleForStatus($transport->status_name);
        }

        return $transports;
    }
    /**
     *
     *
     * @param string $statusName
     * @return mixed
     */
    protected function getStyleForStatus($statusName)
    {
        $class = array(
            'inactive'  => 'danger',
            'on_flight' => 'success',
            'free'      => 'primary',
            'on_repair' => 'warning',
        );

        return $class[$statusName];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

	    $this->authorize('create-transport');

//        if(!app_has_access('transport.all'))
//            abort(404);

        $categories = Category::getCategory()->toArray();
        $types      = Category::getType($categories[0]['id'])->toArray();
        $statuses   = Status::getTransports()
            ->whereIn('name', [TransportStatus::REPAIR, TransportStatus::FREE]);

        return view('transport.create', compact('categories', 'transport', 'statuses', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TransportStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransportStore $request)
    {
//        if(!app_has_access('transport.all'))
//            abort(404);

        $user = $request->user();

        // Validate freelance
        $existsAuto = ($request->selected != 'trailer') && ($request->only_selected == 'auto');

        // Processing
        $service = new TransportService($user);
        $collect = $service->store($request);

        if ($service->isFails()) {
            return response()->json(['status' => 'ERROR', 'message' => $service->getFails()]);
        }

        if (!$user->tutorial){
            $redirectTo = route('user.profile', ['tutorial' => 1]);
        } elseif (!empty($request->get('redirectTo')))
            $redirectTo = $request->get('redirectTo');
        else
            $redirectTo = route('transport.index');

        return response()->json(['status' => 'OK', 'redirectTo' => $redirectTo]);
    }

    /**
     * @param StoreOwnTransport $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOwn(StoreOwnTransport $request)
    {
        $service = new TransportService($request->user());

        DB::beginTransaction();
        try {
            $transport = Transport::query()->create([
                'password'    => bcrypt(str_random(8)),
                'category_id' => $request->get('category'),
                'number'      => $request->get('number') . '-' . $request->get('trailerNumber'),
                'status_id'   => Status::query()->whereName(TransportStatus::FLIGHT)->value('id'),
                'verified'    => true,
                'data'        => $request->only('rollingStock'),
            ]);

            $driver = User::query()->create([
                'email'     => str_random(10),
                'password'  => bcrypt(str_random(8)),
                'name'      => $request->get('driver_name'),
                'phone'     => $request->get('driver_phone'),
                'meta_data' => collect($request->only('driver_licence'))->toJson(),
            ]);

            $driver->roles()->attach(Role::whereName(UserRoleEnums::DRIVER)->value('id'));
            $transport->drivers()->attach($driver->id);

            if ($images = $request->file('images')) {
                foreach ($images as $image) {
                    DocumentService::save($driver, $image);
                }
            }

            $performer = OrderPerformer::whereOrderId($request->get('orderId'))->first();

            if ($performer->transport_id > 0) {
                Transport::query()->find($performer->transport_id)->update(['status_id' => Status::getId("free")]);
            }

            $performer->update(['transport_id' => $transport->id]);

            DB::commit();

            $_transport = $service->transform($transport);

            return response()->json(['status' => 'success', 'transport' => $_transport]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
//        if(!app_has_access('transport.all'))
//            abort(404);

        $drivers   = (new RoleUser())->getDrivers(\Auth::user()->id, true);
//        $drivers   = \Auth::user()->getCompanyStaffByRoleName(UserRoleEnums::DRIVER);
        $statuses  = Status::getTransports()->whereIn('name', [TransportStatus::REPAIR, TransportStatus::FREE]);
        $transport = Transport::query()->findOrFail($id);

        $transport->category     = Category::getName($transport->category_id);
        $transport->type         = Category::getName($transport->type_id);
        $transport->rollingStock = null;
        $transport->isTrailer    = $transport->isTrailer();
        $transport->trailers     = $transport->attachedTrailer()->get();
        $transport->trucks       = $transport->attachedTruck()->get();
        $transport->driver       = $transport->drivers()->first();
        $transport->password     = TransportService::decodePassword($transport->id);

        if ($transport->rolling_stock_type_id != null) {
            $transport->rollingStock = RollingStockType::getName($transport->rolling_stock_type_id);
        }

	    $transportAbleFree = $transport->ableTrailers(\Auth::user()->id)->whereNull('parent_id')->get();

	    $transport->trailers = $transport->trailers->merge($transportAbleFree);

	    $cargo_rolling_stock_types = RollingStockType::where('parent_id', '!=', 0)->get();

        return view('transport.edit', compact('transport', 'statuses', 'drivers', 'cargo_rolling_stock_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransportStore $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(TransportUpdate $request, $id)
    {
//        if(!app_has_access('transport.all'))
//            abort(404);

        $transport = Transport::query()->findOrFail($id);
        $service   = new TransportService($request->user());

        if ($request->file('images')) {
            $service->saveImages($request->file('images'), $transport);
        }

        if($request->cargo_rolling_stock_types){
	        $transport->rolling_stock_type_id = $request->cargo_rolling_stock_types;
        }

        $transport->year         = $request->year;
        $transport->height       = $request->height;
        $transport->length       = $request->length;
        $transport->width        = $request->width;
        $transport->volume       = $request->volume;
        $transport->tonnage      = $request->tonnage;
        $transport->condition    = $request->condition;
        $transport->tachograph   = $request->tachograph;
        $transport->gps_id       = $request->gps_id;
        $transport->tracker_imei = $request->tracker_imei;
        $transport->insurance    = $request->insurance_id;
        $transport->monitoring   = $request->has('gps') ? 'gps' : 'app';
        $transport->status_id    = $request->status;
        $transport->login        = $request->login;
        $transport->password     = bcrypt($request->password);

        $service->syncTransport($transport, $request);
        $service->syncDriver($transport, $request->get('driver'));

        $this->updateStatus($transport);

	    if ($request->has('login') && $request->has('password')) {

		    TransportService::updatePasswordKey($transport->id, $request->password);
	    }

        $transport->save();

        if ($request->get('order') > 0) {
            return redirect()->route('orders.show', ['id' => $request->get('order'), 'tab' => 'transport']);
        }

        $request->session()->flash('msg-success', trans('all.changes_successfully_saved'));
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'redirectTo' => route('transport.index')]);
        }

        return redirect()->route('transport.index');
    }

    /**
     * @param Transport $transport
     */
    protected function updateStatus(Transport $transport)
    {
        $attachedTrans = $transport->isTrailer()
            ? $transport->getAttachTruck()
            : $transport->getAttachTrailer();

        foreach ($attachedTrans as $trans) {
            $trans->status_id = $transport->status_id;
            $trans->save();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function updateAjax(TransportUpdateAjax $request)
    {
        if ($request->get('id') > 0) {
            $transport = Transport::query()->findOrFail($request->get('id'));
            $service   = new TransportService($request->user());
            $field     = $request->get('field');
            $val       = $request->get('val');

	        $isLimit = true;

            switch ($field) {
                case 'driver':
                    $service->syncDriver($transport, $val);
//                    if ($pass = Password::where('name', 'LIKE', "T_{$transport->id}::%")->first()) {
//                        $str = str_random(8);
//                        $pass->update(['name' => "T_{$transport->id}::" . encrypt($str)]);
//                        $transport->update(['password' => bcrypt($str)]);
//                    }
                    break;

                case 'truck':
                case 'trailer':
                    $request->request->add([$field => $val]);
                    $service->syncTransport($transport, $request);
                    break;

                case 'status_id':
                    $transport->update(['status_id' => $request->val]);
                    break;

                case 'active' :

                    if ($request->checked === 'true') {
						// check fot limit
	                    $isLimit = SubscriptionService::checkAutoLimit(null, true);

	                    if($isLimit === true)
							$transport->update(['active' => 1]);
                    } else {
                        $transport->update(['active' => 0]);
                    }
                    break;

                default:
                    if ($field == 'password') {
	                    TransportService::updatePasswordKey($transport->id, $val);
                    }
                    $transport[$field] = ($field == 'password') ? bcrypt($val) : $val;
                    $transport->save();
            }

            if($isLimit === false){
            	return response()->json(['status' => 'limit']);
            }

            if ($request->has('coupling') && $val != 'reset') {
                $trailer = Transport::query()->findOrFail($val);
                $html    = view('transport.partials.specifications', ['isCoupling' => true, 'transport' => $trailer])->render();

                return response()->json(['status' => 'success', 'isCoupling' => true, 'data' => $html]);
            }

            return response()->json(['status' => 'success', 'data' => $request->all()]);
        }

        return response()->json(['status' => 'error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $transport            = Transport::query()->findOrFail($id);

            $orders_active_transport = $transport->getAttachedOrders()->where('current_status_id', 1)->get();

            if (count($orders_active_transport)) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'active']);
                }
                return redirect()->back();
            }

            $transport->parent_id = null;
            $transport->coupling  = 0;
            $transport->save();

            if ($trailer = Transport::where('parent_id', $transport->id)->first()) {
                $trailer->parent_id = null;
                $trailer->save();
            }

            $transport->drivers()->detach();
            $transport->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'success']);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
            }

            return redirect()->back();
        }
    }

    /**
     * Get a list of available transport
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getAvailable(Request $request)
    {
        $transport = Transport::query()->findOrFail($request->id);
        $list      = [];
        $html      = '';

        if ($transport->hasStatus(TransportStatus::FLIGHT)) {
            throw new \Exception('Transport on flight..');
        }

        switch ($request->type) {
            case 'trailer':
                $list     = $transport->ableTrailers($request->user()->id)->whereNull('parent_id')->get();
                $attached = $transport->attachedTrailer()->first() ?? null;
                break;

            case 'truck':
                $list     = $transport->ableTrucks($request->user()->id)->get();
                $attached = $transport->attachedTruck()->first() ?? null;
                break;
        }

        $html .= '<option value="0">' . trans('all.no_chosen') . '</option>';

        if ($attached) {
            $html .= '<option value="'. $attached->id .'" selected>' . $attached->number . '</option>';
        }

        foreach ($list as $transport) {
            $html     .= '<option value="'.$transport->id.'">'.$transport->number.'</option>';
        }

        if (!is_array($list) && $list->isEmpty() && $attached === null) {
            $html .= '<option value="0" disabled>' . trans('all.empty_list') . '</option>';
        }

        return response()->json(['status' => 'success', 'html' => $html]);
    }

    /**
     * Send SMS, to driver, with credentials
     * @param $transport_id
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendSMS($id){

        $transport = Transport::query()->findOrFail($id);
        if ($driver = $transport->drivers()->first()) {

            $msg = trans('sms.access', [ 'login' => $transport->login, 'password' => TransportService::decodePassword($transport->id)]);
            if(TwilioService::sendSMS($driver->phone, $msg))
                return response()->json(['status' => 'success']);
            else
                return response()->json(['message' => 'SMS sending error']);

        }

        return response()->json(['message' => 'Driver not found']);
    }

    public function deleteImage(Request $request, $id) {

        if ($request->type === 'img') {

            $image = Image::findOrFail($id);
            $image->delete();

        } elseif ($request->type === 'doc') {
            $image = Document::findOrFail($id);
            $image->delete();
        }


        return 'success';
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
