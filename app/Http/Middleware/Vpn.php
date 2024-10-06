<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Vpn
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // skip if not in production
        if (! env('APP_IS_VPN')) {
            return Redirect::route('error');
        }

        return $next($request);
    }
}
