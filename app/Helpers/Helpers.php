<?php

if (!function_exists('app_class_base_name')) {
    /**
     * Get a class base name
     *
     * @param  string $className
     * @return string  to lower
     */
    function app_class_base_name($className)
    {
        return strtolower(substr(strrchr($className, "\\"), 1));
    }
}

if (!function_exists('app_document_url')) {
    /**
     * @param string $directory
     * @param string $fileName
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function app_document_url($fileName, $directory = 'documents')
    {
        return url('storage/' . $directory . '/' . $fileName);
    }
}

if (!function_exists('app_image_transport_url')) {
    /**
     * @param string $directory
     * @param string $fileName
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function app_image_transport_url($fileName, $directory = 'transports')
    {
        return url('storage/' . $directory . '/' . $fileName);
    }
}

if (!function_exists('app_avatar_url')) {
    /**
     * @param string $directory
     * @param string $fileName
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function app_avatar_url($fileName, $directory = 'users')
    {
        $path = $fileName
            ? 'storage/' . $directory . '/' . $fileName
            : '/img/default-profile.jpg';

        return url($path);
    }
}

if (!function_exists('app_avatar_exists')) {
	/**
	 * @param string $directory
	 * @param string $fileName
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	function app_avatar_exists($fileName)
	{
		if (file_exists(public_path().'/storage/users/'.$fileName))
			return true;
		else
			return false;
	}
}

if (!function_exists('app_convert_speed')) {
    /**
     * Convert m/sec into km/hr
     *
     * @param $speed
     * @return float|int
     */
    function app_convert_speed($speed)
    {
        return ($speed * 18) / 5; // 3600sec/1000m = 18/5
    }
}

if (!function_exists('app_map_distance')) {
    /**
     * Calculate distance, bearing and more between Latitude/Longitude points
     *
     * @param string $fromPoint 'lat,lng'
     * @param string $toPoint 'lat,lng'
     * @return int
     */
    function app_map_distance($fromPoint, $toPoint)
    {
        $R = 6371e3; //the earth's radius in metres

        list($fromLatA, $fromLngA) = explode(',', $fromPoint);
        list($toLatB, $toLngB) = explode(',', $toPoint);

        $latA  = $fromLatA * (M_PI / 180);
        $lngA  = $fromLngA * (M_PI / 180);
        $latB  = $toLatB * (M_PI / 180);
        $lngB  = $toLngB * (M_PI / 180);
        $subBA = bcsub($lngB, $lngA, 20);

        return round($R * acos(cos($latA) * cos($latB) * cos($subBA) + sin($latA) * sin($latB)));
    }
}


if (!function_exists('app_map_distance_coo')) {
    /**
     * Calculate distance, bearing and more between Latitude/Longitude points
     *
     * @param string $fromPoint 'lat,lng'
     * @param string $toPoint 'lat,lng'
     * @return int
     */
    function app_map_distance_coo($fromLatA, $fromLngA, $toLatB, $toLngB)
    {
        $R = 6371e3; //the earth's radius in metres

        $latA  = $fromLatA * (M_PI / 180);
        $lngA  = $fromLngA * (M_PI / 180);
        $latB  = $toLatB * (M_PI / 180);
        $lngB  = $toLngB * (M_PI / 180);
        $subBA = bcsub($lngB, $lngA, 20);

        return round($R * acos(cos($latA) * cos($latB) * cos($subBA) + sin($latA) * sin($latB)));
    }
}

if (!function_exists('user_current_can')) {

    function user_current_can($module_name, $type = false)
    {
        return \App\Models\User::userCurrentCan($module_name, $type);
    }
}

if (!function_exists('user_can')) {

    function user_can($user, $module_name, $type = false)
    {
        return \App\Models\User::userCan($user, $module_name, $type);
    }
}

if (!function_exists('profile_filled')) {

    function profile_filled()
    {
        $user = auth()->user();

        if(isset($user->meta_data['type']) && in_array($user->meta_data['type'], ['company', 'individual'])){
            return true;
        }
        return false;
    }
}

if (!function_exists('del_pre_order')) {

	function del_pre_order($type)
	{
		$user = auth()->user();

		$meta_data = $user->meta_data;

		if(isset($meta_data[$type])){
			unset($meta_data[$type]);
		}

		$user->meta_data = count($meta_data) == 0 ? null : $meta_data;

		$user->save();
	}
}

if (!function_exists('user_tutorials')) {

	function user_tutorials($page){

		$user = auth()->user();

//		if(\Request::get('param') === '1'){
//			return true; // TODO For test only
//		}

		if($user && $user->tutorial === 1){
			return false;
		}

		$expire = time() + (10 * 365 * 24 * 60 * 60);

//		\Cookie::queue(\Cookie::forget('tutorials_'.$page));

		$page_title = 'tutorials_'.$page;

		$userDataService = new \App\Services\UserDataService();

		if(\Cookie::get($page_title) === null || $userDataService->get($user->id, $page_title) === false){
			\Cookie::queue(\Cookie::make('tutorials_'.$page, 1, $expire));
			$userDataService->set($user->id, $page_title, 1);
			return true;
		}

		return false;
	}
}

if (!function_exists('checkPaymentAccess')) {
	/**
	 * @param $featureSlug
	 *
	 * @return bool
	 */
	function checkPaymentAccess($featureSlug){
		$result = \App\Services\SubscriptionService::checkFeatureUsage($featureSlug);

		if($result > 0)
			return true;

		return false;
	}
}

if (!function_exists('checkPaymentFeatureUsage')) {
	/**
	 * Get value of feature
	 *
	 * @param $featureSlug
	 *
	 * @return integer
	 */
	function checkPaymentFeatureUsage($featureSlug){
		return \App\Services\SubscriptionService::checkFeatureUsage($featureSlug);
	}
}

if (!function_exists('getPaymentSubscription')) {
	/**
	 * Get current subscription info
	 *
	 * @return object
	 */
	function getPaymentSubscription(){
		return \App\Services\SubscriptionService::getSubscription();
	}
}

if (!function_exists('innlogger')) {
	/**
	 * @param $message
	 */
	function innlogger($message){
		\Log::channel('innlogist')->info($message);
	}
}

if (!function_exists('innlogger_pay')) {
	/**
	 * @param $message
	 */
	function innlogger_pay($message){
		\Log::channel('innlogist_pay')->info($message);
	}
}

if (!function_exists('innlogger_geo')) {
	/**
	 * @param $message
	 */
	function innlogger_geo($message){
		\Log::channel('innlogist_geo')->info($message);
	}
}

if (!function_exists('innlogger_sign')) {
	/**
	 * @param $message
	 */
	function innlogger_sign($message){
		\Log::channel('innlogger_sign')->info($message);
	}
}

if (!function_exists('innlogger_google')) {
	/**
	 * @param $message
	 */
	function innlogger_google($message){
		\Log::channel('innlogist_google')->info($message);
	}
}

if (!function_exists('formatBytes')) {
	/**
	* Format bytes to kb, mb, gb, tb
	*
	* @param integer $size
	* @param integer $precision
	* @return integer
	*/
	function formatBytes($size, $precision = 2)
	{
		if ($size > 0) {
			$size     = (int) $size;
			$base     = log($size) / log(1024);
			$suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];
			return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
		} else {
			return $size;
		}
	}
}

if (!function_exists('template_filename')) {
	/**
	 * Convert template filename
	 * @param $message
	 */
	function template_filename($slug){
		return \Illuminate\Support\Str::snake($slug);
	}
}
