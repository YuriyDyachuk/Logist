<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Controllers\Controller;
use App\Models\UserDevice;

use App\Jobs\Driver\ProcessReportNotification;

class AuthController extends Controller
{
	/**
	 * @OA\Post(
	 *      path="/api/v2/login",
	 *      operationId="login",
	 *      tags={"Auth"},
	 *      summary="Login",
	 *      description="Return token",
	 *      @OA\Response(
	 *          response=200,
	 *          description="Return token, transport info, driver info",
	 *       ),
	 *     )
	 */
    public function login(Request $request)
    {
        $validator = $this->validateLogin($request);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $credentials = $request->only('login', 'password');
        $token       = null;

        try {
//            if (!$token = JWTAuth::attempt($credentials)) {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        $transport = auth()->user();

        if($request->has('push_login')){
			$this->removeBlock();
        }

	    $this->removeBlock(); // TODO TEST

        $isBlock = $this->checkBlock();

        if($isBlock){
            auth()->logout();
            return response()->json(['message' => 'Could not create token. Another device used'], 500);
        }

        if ($driver = $transport->drivers()->first()) {

	        ProcessReportNotification::dispatch($transport->id);

            $driver->update(['locale' => $request->header('lang')]);
            $transport->update(['last_login' => date('Y-m-d H:i:s')]);
            $image              = $driver->images()->first();
            $driver->avatar     = $image ? url('storage/users/' . $image->filename) : null;
            $transport_image    = $transport->images()->first();
            $transport->avatar  = $transport_image ? url('storage/transports/'. $transport_image->filename) : null;

            $lang = $driver->locale;

            $gcm = UserDevice::setUserDevice($driver->id, $request);

            return response()->json(compact('token', 'transport', 'driver', 'lang', 'gcm'));
        }

	    return response()->json(['message' => 'Not found a driver'], 404);
    }

    private function checkBlock(){
        $redis = Redis::connection();

        $transport = auth()->user();

        $env = config('app.env');
        $redis_transport_id_key = $env.'transportid_'.$transport->id;
        $redis_transport_status_key = $env.'transportstatus_'.$transport->id;

        if(!$redis->exists($redis_transport_id_key)){
            $redis->set($redis_transport_id_key, $transport->id);
            $redis->expire($redis_transport_id_key, 60);

            $redis->set($redis_transport_status_key, $transport->status_id);
            $redis->expire($redis_transport_status_key, 60);

            return false;
        }

        return true;
    }

    private function removeBlock(){
        $redis = Redis::connection();

        $transport = auth()->user();
        $env = config('app.env');
        $redis_transport_id_key = $env.'transportid_'.$transport->id;
        $redis_transport_status_key = $env.'transportstatus_'.$transport->id;

        $redis->del([$redis_transport_id_key, $redis_transport_status_key]);
//        $redis->del($redis_transport_status_key);
    }

	/**
	 * @OA\Get(
	 *      path="/api/v2/logout",
	 *      operationId="logout",
	 *      tags={"Auth"},
	 *      summary="Logout",
	 *      description="Returns order",
	 *      @OA\Response(
	 *          response=200,
	 *          description="New token",
	 *       ),
	 *     )
	 */
    /**
     * Logout user to application.
     *
     * @return empty
     */
    public function logout()
    {
        $this->removeBlock();
	    auth()->logout();

        return response()->json(['success']);
    }

    public function validateLogin(Request $request)
    {
        return \Validator::make($request->all(), [
            'login'=> 'required',
            'password'=> 'required',
        ]);
    }

	/**
	 * @OA\Get(
	 *      path="/api/v2/refresh",
	 *      operationId="refreshToken",
	 *      tags={"Auth"},
	 *      summary="Get new Token [NEED FOR TEST!!! UPDATED]",
	 *      description="Returns order",
	 *      @OA\Response(
	 *          response=200,
	 *          description="New token",
	 *       ),
	 *     )
	 */
    public function refresh(){

	    $token_new = auth()->refresh(false, true);

//	    $token = JWTAuth::getToken();
//	    $token_new = JWTAuth::refresh($token);

	    return response()->json(['token' => $token_new]);
    }

    public function need_to_update(){
		return response()->json(['error' => 'Please update App'], 440);
    }

}
