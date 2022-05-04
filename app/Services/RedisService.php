<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class RedisService {

	public static function clearTransportInfo($transport_id){
		$env = config('app.env');
		$redis = Redis::connection();

		$redis_transport_id_key = $env.'transportid_'.$transport_id;
		$redis_order_id_key = $env.'transportidorderid_'.$transport_id;

		if($redis->exists($redis_transport_id_key)){
			$redis->del([$redis_transport_id_key]);

		}

		if($redis->exists($redis_order_id_key)){
			$redis->del([$redis_order_id_key]);
		}
	}

	public static function getParam($key, $expiration_time = null){
		$redis = Redis::connection();
		$key = self::getEnv().$key;
		if($redis->exists($key)){
			return $redis->get($key);
		}

		return false;
	}

	public static function setParam($key, $value, $expiration_time = 3600){
		$redis = Redis::connection();
		$key = self::getEnv().$key;
		$redis->set($key, $value);
		$redis->expire($key, $expiration_time);
	}

	private static function getEnv(){
		return config('app.env');
	}

}