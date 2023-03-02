<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ApiResponseTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (!defined('LARAVEL_START')) {
            $laravelStart = microtime(true);
        }

        $response_time = (microtime(true) - $laravelStart) * 1000;
        $redis = Redis::connection();
        $response_times = $redis->get('API_RESPONSE_TIMES');
        $response_times = json_decode($response_times);
        if (!is_array($response_times)) {
            $response_times = [];
        }
        array_push($response_times, $response_time);
        $redis->set('API_RESPONSE_TIMES', json_encode($response_times));
        return ($response);
    }
}
