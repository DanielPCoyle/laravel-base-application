<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else{
            $ip = $_SERVER['REMOTE_ADDR'] ?? "unknown";
        }
        Log::debug($request->method()." Call made from ".$ip);
        
        return $next($request);
    }

    public function terminate($request,$response)
    {
        Log::debug($response->status());
        if($request->method() == "GET") {
            if($response->original !== null  
                && (isset($response->original->entity))
            ) {
                Log::debug("Entity ".$response->original->entity." | Event get_data");       
            }
        }
        
        if(is_array($response->original) && isset($response->original['event'])) {
            Log::debug("Entity ".$response->original['entity']." | Event ".$response->original['event']);       
        }
    }
}
