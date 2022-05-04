<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

use App\Models\Transport\Transport;

class JwtCheckDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $redis = Redis::connection();

        $token = JWTAuth::getToken();

        if($token){
            $data = JWTAuth::getPayload($token)->toArray();
            $transport_id = $data['sub'];

            $env = config('app.env');
            $redis_transport_key = $env.'transport_'.$transport_id;
            $redis_transport_id_key = $env.'transportid_'.$transport_id;
            $redis_transport_status_key = $env.'transportstatus_'.$transport_id;

            if(!$redis->exists($redis_transport_key)){
                $transport = Transport::find($transport_id);
                $redis->set($redis_transport_key, $transport);
                $redis->expire($redis_transport_key, 3600);
            }
            else {
                $transport = json_decode($redis->get($redis_transport_key));
            }

            $redis->set($redis_transport_id_key, $transport_id);
            $redis->expire($redis_transport_id_key, 60);

            $redis->set($redis_transport_status_key, $transport->status_id);
            $redis->expire($redis_transport_status_key, 60);
        }



        return $next($request);
    }
}
