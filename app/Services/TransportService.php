<?php
/**
 * Author: Vitalii Pervii
 * Author URI: https://www.amconsoft.com/
 * Date: 07.08.2018
 */

namespace App\Services;


use App\Enums\TransportStatus;
use App\Models\Document\DocumentType;
use App\Models\Transport\RollingStockType;
use App\Models\Transport\Transport;
use App\Models\Transport\TransportDriver;
use App\Models\Transport\TransportKey as Password;
use App\Models\Order\CargoLoadingType;
use App\Models\User;
use App\Models\Transport\Category;
use App\Search\Transport\TransportSearch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Services\StatusService;
use App\Services\AmplitudeService;
use App\Services\LogisticService;

class TransportService extends BaseService
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Transport
     */
    protected $transport;

    /**
     * TransportService constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function store(Request $request)
    {
        $transport = new \Illuminate\Support\Collection();

        switch ($request->get('selected')) {
            case 'tractor':
            case 'truck':

            $transport->put('auto', $this->save($request, 'auto'));
                break;

            case 'train':
            case 'coupling':
                if ($request->has('only_selected')) {
                    $type = $request->get('only_selected');
                    $transport->put($type, $this->save($request, $type));
                } else {
                    $_transport = $this->save($request, 'auto');
                    $transport->put('auto', $_transport);
                    $transport->put('trailer', $this->save($request, 'trailer', $_transport->id));
                }
                break;

            case 'trailer':
                $transport->put('trailer', $this->save($request, 'trailer'));
                break;
        }

        return $transport;
    }

    public function need()
    {

    }

    /**
     * @param Request $request
     * @param $type
     * @param null $attachId
     * @return Transport
     */
    private function save(Request $request, $type, $attachId = null)
    {
        \DB::beginTransaction();
        try {
            $transport = new Transport();

            $transport['user_id']               = $this->user->isAdmin() ? $this->user->parent_id : $this->user->id;
            $transport['inner_id']              = $this->getInnerId($this->user->id);
            $transport['category_id']           = $request->input('category');
            $transport['type_id']               = $request->input("{$type}.type");
            $transport['loading_type_id']       = $request->input("{$type}.type_loading");
            $transport['number']                = $request->input("{$type}.number");
            $transport['model']                 = $request->input("{$type}.model");
            $transport['year']                  = $request->input("{$type}.truck_year") ? $request->input("{$type}.truck_year") : $request->input("{$type}.year");
            $transport['condition']             = $request->input('condition');
            $transport['tonnage']               = $request->input("{$type}.tonnage");
            $transport['height']                = $request->input("{$type}.height");
            $transport['length']                = $request->input("{$type}.length");
            $transport['width']                 = $request->input("{$type}.width");
            $transport['volume']                = $request->input("{$type}.volume");
            $transport['rolling_stock_type_id'] = $request->input("{$type}.rolling_stock_type");
            $transport['status_id']             = $request->input('status');

            $transport['tracker_imei'] = $request->input('tracker_imei');
            $transport['gps_id']       = $request->input('gps_id');
            $transport['insurance']    = $request->input('insurance_id');
            $transport['monitoring']   = $request->input('gps_id') ? 'gps' : 'app';

            $transport['login']    = ($type !== 'trailer') ? $request->input('login') : null;
            $transport['password'] = $request->has('password') ? bcrypt($request->password) : null;
            $transport['verified'] = true;

            $transport->save();

            (new StatusService)->updateTransportStatus($transport->id, $transport['status_id']);

            if ($request->has('login') && $request->has('password')) {
                Password::query()
                    ->create(['name' => "T_{$transport->id}::" . encrypt($request->password)]);
            }

            //STORE IMAGES IN STORAGE
            $files = $request->file("{$type}.images");
	        if($files){
		        $this->saveImages($files, $transport);
	        }


            if ($attachId) {
                $request->request->add(['truck' => $attachId]);
                $this->syncTransport($transport, $request);
            }

            (new AmplitudeService())->request('Add transport', [
                'transport_type'    => $type,
                'type_or_trailer'   => $request->get('selected'),
                'type_of_loading'   => ($transport->loadingType) ? $transport->loadingType->name : '',
            ]);

            \DB::commit();

            return $transport;
        } catch (\Exception $e) {
            \DB::rollback();
            $this->errors = ['line' => $e->getLine(), 'message' => $e->getMessage()];
        }
    }

    /**
     * @param Transport $transport
     * @param Request $request
     * @return bool
     */
    public function syncTransport(Transport $transport, Request $request)
    {
        if ($isTrailer = $transport->isTrailer()) {
            $transport->parent_id = ($request->truck == 'reset') ? null : $request->truck;
            Transport::query()
                ->where('id', $transport->parent_id)
                ->update(['coupling' => ($request->truck != 'reset')]);
        } elseif ($request->has('trailer')) {
            $transport->coupling = false;
            Transport::query()
                ->where('parent_id', $transport->id)
                ->update(['parent_id' => null]);

            if ($request->trailer != 'reset') {
                $transport->coupling = true;
                Transport::query()
                    ->where('id', $request->trailer)
                    ->update(['parent_id' => $transport->id]);
            }
        }

        return $transport->save();
    }

    /**
     * @param Transport $transport
     * @param $driverId
     * @return bool|\Illuminate\Database\Eloquent\Model|null
     * @throws \Exception
     */
    public function syncDriver(Transport $transport, $driverId)
    {
        if ($driverId > 0) {
            return TransportDriver::query()->updateOrCreate(
                ['transport_id' => $transport->id],
                ['user_id' => $driverId,]
            );
        }

        return TransportDriver::query()->where('transport_id', $transport->id)->delete();
    }

    /**
     * @param $files
     * @param Transport $transport
     */
    public function saveImages($files, Transport $transport)
    {
        foreach ($files as $key => $images) {
            switch ($key) {
                case 'transport':
                    ImageService::save($transport, $images, 'transports');
                    break;

                case 'documents':
                    $type = DocumentType::search('technical_passport_transport');
                    foreach ($images as $image) {
                        DocumentService::save($transport, $image, $type->id);
                    }
                    break;
            }
        }
    }

    /**
     * Get inner id for a transport
     *
     * @param $userId
     * @return int
     */
    private function getInnerId($userId)
    {
        $id = Transport::where('user_id', $userId)->max('inner_id') ?? 0;

        return ++$id;
    }

    /**
     * @param integer $transportId
     * @return string
     */
    public static function decodePassword($transportId)
    {
        $password = Password::query()
            ->where('name', 'LIKE', 'T_' . $transportId . '::%')
            ->first();

        if ($password) {
            return decrypt(substr($password->name, strrpos($password->name, '::') + 2));
        }

        return $password;
    }

    /**
     * @return Collection
     */
    public function findSuitable($order = null)
    {
        $filters = [
            'user'     => $this->user->id,
            'type'     => Category::whereIn('name', ['tractor', 'truck', 'special_machinery'])->pluck('id'),
            'verified' => true,
            'status'   => TransportStatus::FREE,
            'parent_id'=> null,
            'isDriver' => true,
            'active'   => 1,
            'relationships' => true
        ];

		// TODO checkPaymentAccess - correct in the future
        if(checkPaymentAccess('transports_search') && $order && $order->cargo->rollingStockType){
			// TODO
//            $filters['rolling_stock'] = $order->cargo->rollingStockType->id;
        }

        return TransportSearch::apply($filters)->get();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $transports
     * @return Collection
     */
    public function transforms(Collection $transports)
    {
        foreach ($transports as $key => $transport) {

            $transport['trailer'] = $transport->getAttachTrailer();

            if ($transport->user_id == null) {
//                $data                       = json_decode($transport->data, true);
                $num                        = explode('-', $transport['number']);
                $transport['number']        = $num[0];
                $transport['trailerNumber'] = key_exists(1, $num) ? $num[1] : '';
                $transport['rollingStock']  = $transport->data['rollingStock'] ?? '';
            } else {
                $transport['trailerNumber'] = $transport['trailer'][0]['number'] ?? '';
                $transport['typeName']      = trans('handbook.' . Category::getName($transport->type_id));

                if ($transport->rolling_stock_type_id > 0) {
                    $transport['rollingStock'] = trans('handbook.' . RollingStockType::getName($transport->rolling_stock_type_id));
                } else {

//	                $rolling_stock_type_id = (isset($transport['trailer'][0]) && $transport['trailer'][0]->rolling_stock_type_id !== null) ? true : false;

                    $transport['rollingStock'] = (isset($transport['trailer'][0]) && $transport['trailer'][0]->rolling_stock_type_id !== null)
                        ? trans('handbook.' . RollingStockType::getName($transport['trailer'][0]->rolling_stock_type_id))
                        : '';
                }

	            if ($transport->loading_type_id > 0) {
		            $transport['loadingType'] = trans('cargo.' . CargoLoadingType::getSlug($transport->loading_type_id));

	            } else {
		            $transport['loadingType'] = (isset($transport['trailer'][0]) && $transport['trailer'][0]->loading_type_id !== null)
			            ? trans('cargo.' . CargoLoadingType::getSlug($transport['trailer'][0]->loading_type_id))
			            : '';
	            }
            }

            $transport['drivers'] = $transport->drivers()->get();

            foreach ($transport['drivers'] as $driver) {
                // If driver is a freelance
                if (!isset($driver['meta_data'])) {
                    $driver->meta_data = ['driver_licence'=> ''];
                }
                $license = $driver->documents()
                    ->whereDocumentTypeId(DocumentType::whereName("driver's_license")->value('id'))->first();

                $driver['picLicense'] = [\Image::getPath('documents', $license->filename ?? '')];
            }
        }

        return $transports;
    }

    /**
     * @param Transport $transport
     * @return Transport
     */
    public function transform(Transport $transport)
    {
        $collect = (new Collection())->add($transport);

        return $this->transforms($collect)->first();
    }

	/**
	 *
	 * Get transports using filters
	 *
	 * @param array $filters
	 *
	 * @return Collection|static[]
	 */
    public static function getTransports($filters = []){

		if(is_array($filters) && !isset($filters['user'])){
		    $filters['user'] = LogisticService::getLogistsArray();
	    }

	    if(is_array($filters) && !isset($filters['type'])){
		    $filters['type'] = 'auto';
	    }

	    return \App\Search\Transport\TransportSearch::apply($filters)->get();
    }

	/**
	 * Update Transport Password
	 *
	 * @param $transport
	 * @param $password
	 */
    public static function updatePasswordKey($transport_id, $password){
	    $pass = Password::where('name', 'LIKE', "T_{$transport_id}::%")->first();

	    if ($pass) {
		    $pass->update(['name' => "T_{$transport_id}::" . encrypt($password)]);
	    } else {
		    Password::create(['name' => "T_{$transport_id}::" . encrypt($password)]);
	    }
    }
}