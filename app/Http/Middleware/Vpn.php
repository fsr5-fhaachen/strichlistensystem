<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Vpn
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
        // skip if not in production
        if (app()->environment() !== 'production') {
            return $next($request);
        }


        if (!$_SERVER['HTTP_X_REAL_IP'] || $_SERVER['HTTP_X_REAL_IP'] != env('APP_VPN_IP')) {
            return Redirect::route('error');
        }

        return $next($request);
    }
}
