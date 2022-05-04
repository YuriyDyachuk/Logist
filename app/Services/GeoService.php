<?php

namespace App\Services;


use App\Models\CredentialsOutside;
use App\Models\Transport\Transport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Geo;
use App\Models\OrderGeo;

class GeoService
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * GeoService constructor.
     * @param Collection $transports
     */
    public function __construct(Collection $transports)
    {
        $this->collection = $transports;
    }

    /**
     * @param Transport $transport
     * @param $from_date
     * @param $to_date
     * @return array
     */
    public static function getDirections(Transport $transport, $from_date, $to_date, $order_id = null)
    {
        $directions = [];


        if ($transport->gps_id && $transport->monitoring == 'gps') {
            $key = CredentialsOutside::query()->where('user_id', \Auth::user()->id)->value('api_key');
            if ($key) {
                $data = [
                    'key'       => decrypt($key),
                    'from_date' => date('d.m.Y', strtotime(str_replace('/', '-', $from_date))),
                    'to_date'   => date('d.m.Y', strtotime(str_replace('/', '-', $to_date))),
                    'ids'       => $transport->gps_id,
                ];

                $directions = (new GlobusService)->getDirections($data);
            }
        } else {

            if(is_null($order_id)) {
                $directions = $transport->geo->map(function ($item) {
                    return [$item->lat, $item->lng, $item->status_id];
                });
            } else {

                $geo = $transport->geo_order($order_id)->get();

                $directions = $geo->map(function ($item) {
                    return [$item->lat, $item->lng, $item->status_id];
                });
            }
        }

        return $directions;
    }

    /**
     * @return void
     */
    public function createOrUpdateDataGeo()
    {
        $dataGeo = [];
        $devices = [];

        try {
            $devices = (new GlobusService())->receive();
        } catch (\Exception $e) {
            $this->errors['globus'] = 'Globus GPS - Service Unavailable. ' . $e->getMessage();
        }

        foreach ($this->collection as $transport) {

            foreach ($devices as $device) {
                $created_at = date('Y-m-d H:i:s', strtotime($device['lastKnownTime']));
                $created_at_unix = strtotime($device['lastKnownTime']);

                $geo = null;
                if($transport->gps_id == $device['regId']){
	                $geo = $transport->geo->first();
                }

                $isFresh    = !$geo || ($geo->created_at != $created_at);

                if ($transport->gps_id == $device['regId'] && ($transport->monitoring == 'gps') && $isFresh) {

	                $odometer = 0;
	                $fuel = 0;

					foreach ($device['sensorsValues'] as $sensor){

						// name = Одометр
						if($sensor['num'] == 17 && isset($sensor['scaledValue'])){
							$odometer = $sensor['scaledValue'];
		                }

		                // name = Расход ДТ
		                if($sensor['num'] == 16 && isset($sensor['scaledValue'])){
			                $fuel = $sensor['scaledValue'];
		                }
	                }

	                $key_lat = 'globus_old_lat_'.$transport->id;
	                $key_lng = 'globus_old_lng_'.$transport->id;
	                $key_time = 'globus_old_time_'.$transport->id;
	                $key_ignition = 'globus_ignition_'.$transport->id;

	                $old_lat = \App\Services\RedisService::getParam($key_lat);
	                $old_lng = \App\Services\RedisService::getParam($key_lng);
	                $old_time = \App\Services\RedisService::getParam($key_time);

	                if($old_lat === false)
		                $old_lat = 0;

	                if($old_lng === false)
		                $old_lng = 0;


	                $dist = app_map_distance_coo($device['latitude'], $device['longitude'], $old_lat, $old_lng);

	                if($dist > 200 && $created_at_unix != $old_time) // 100m
	                {

		                // new Value
		                \App\Services\RedisService::setParam($key_lat, $device['latitude']);
		                \App\Services\RedisService::setParam($key_lng, $device['longitude']);
		                \App\Services\RedisService::setParam($key_time, $created_at_unix);
		                \App\Services\RedisService::setParam($key_ignition, $device['ignition']['on']);

		                $transport->update([
							'lat' => $device['latitude'],
							'lng' => $device['longitude'],
		                ]);

		                $dataGeo[] = [
			                'transport_id' => $transport->id,
			                'order_id'     => $transport->getAttachedOrder()->id ?? 0,
			                'lat'          => $device['latitude'],
			                'lng'          => $device['longitude'],
			                'speed'        => app_convert_speed($device['speed']),
			                'ignition'     => $device['ignition']['on'],
			                'odometer'     => $odometer,
			                'fuel'         => $fuel,
			                'data'         => json_encode($device['sensorsValues']),
			                'gps_type_id'  => 2,
			                'datetime'     => $created_at,
			                'status_id'    => $transport->status_id == 6 ? 1 : null, // if in flight
			                'created_at'   => date('Y-m-d H:i:s'),
			                'updated_at'   => date('Y-m-d H:i:s'),
		                ];
	                }
                }
            }
        }

//        \DB::table('geo')->insert($dataGeo); // TODO remove
        \DB::table('order_geo')->insert($dataGeo);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
    public static function geoOnlineOptimize($order_id)
    {
        $min_normal_dist=200;
        $points = OrderGeo::where('order_id', $order_id)->where('is_check',0)->orderby('datetime')->get();
        $old_point = null;
        foreach ($points as $point)
        {
            if ($old_point == null) {
                $old_point = $point;
                $point->is_check = 1;
                $point->save();
                continue;
            }
            $dist = app_map_distance_coo($point->lat, $point->lng, $old_point->lat, $old_point->lng);
            if ($dist < $min_normal_dist) {
                $point->delete();
            } else {
                $point->is_check = 1;
                $point->save();
                $old_point = $point;
            }
        }
    }
    public static function geoOptimize($order_id)
    {
        return;

        $max_normal_dist=1000;
        $min_normal_dist=200;
        $big_distance = 5000;
        $max_count_iteration = 10;
        $step=0;
        $take=30000;
        $count_beg=0;
        $new_array=[];
        while ($points = Geo::where('order_id', $order_id)->orderby('id')->skip($step*$take)->take($take)->get()->toarray())
        {
            $step++;
            $count_beg += count($points);
            $old_point = null;
            $nap_lat=0;
            $nap_lng=0;
            $old_nap_lat=0;
            $old_nap_lng=0;
            $count_iter = 0;

            foreach ($points as $key=>$point) {
                if ($old_point == null) {
                    $old_point = $point;
                    $new_array[] = $point;
                    continue;
                }
                $dist = app_map_distance_coo($point['lat'], $point['lng'], $old_point['lat'], $old_point['lng']);
                //print $point['id'].' '.$point['lat'].':'.$point['lng'].' '.$old_point['lat'].':'.$old_point['lng'].' dist='.$dist.'<br>';
                $nap=false;
                if ($dist >= $min_normal_dist) {
                    //направление вектора
                    if ($old_point['lat'] != $point['lat'] || $old_point['lng'] != $point['lng']) {
                        $nap_lat = ((floatval($old_point['lat']) - floatval($point['lat']))<0? -1 : 1);
                        $nap_lng = ((floatval($old_point['lng']) - floatval($point['lng']))<0? -1 : 1);
                        if ($old_nap_lat == 0)
                        {
                            $old_nap_lat = $nap_lat;
                            $old_nap_lng = $nap_lng;
                            continue;
                        }
                    }
                    if ($old_nap_lat == $nap_lat || $old_nap_lng == $nap_lng || $count_iter>$max_count_iteration) {
                        $nap=true;
                        $old_nap_lat = $nap_lat;
                        $old_nap_lng = $nap_lng;
                    }

                    if (($dist < $max_normal_dist && $nap) || $count_iter>$max_count_iteration) {
                        $old_point = $point;
                        $new_array[] = $point;
                        $count_iter=0;
                    }
                    $count_iter++;
                } else {
                    continue;
                }

            }
            unset($points);
        }
        $old_point = null;
        $points=$new_array;
        
        $new_array=[];
        foreach ($points as $point)
        {
            unset($point['id']);
            if ($old_point == null) {
                $old_point = $point;
                $new_array[] = $point;
                OrderGeo::insert($point);
                continue;
            }
            $dist = app_map_distance_coo($point['lat'], $point['lng'], $old_point['lat'], $old_point['lng']);
            if ($dist > $big_distance)
            {
                $new_points = (new \App\Services\GoogleService())->getRoutePoints($old_point['lat'].','.$old_point['lng'], $point['lat'].','.$point['lng']);
                foreach ($new_points as $item)
                {
                    $tmp_point=$old_point;
                    $tmp_point['lat'] = $item[0];
                    $tmp_point['lng'] = $item[1];
                    $new_array[] = $tmp_point;
                    OrderGeo::insert($tmp_point);
                }
            }
            else {
                $new_array[] = $point;
                OrderGeo::insert($point);
            }
            $old_point = $point;
        }
        return $new_array;
    }

}