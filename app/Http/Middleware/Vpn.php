<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        if ($request->ip() != env('APP_VPN_IP')) {
            return response()->json([
                'error' => 'Not authorized.'
            ], 403);
        }

        return $next($request);
    }
}