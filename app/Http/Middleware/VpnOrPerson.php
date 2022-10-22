<?php

namespace App\Http\Middleware;

use App\Models\Person;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VpnOrPerson
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
        if (!$_SERVER['HTTP_X_REAL_IP'] || ($_SERVER['HTTP_X_REAL_IP'] != env('APP_VPN_IP') &&
            ($request->session()->missing('authToken') ||
                !Person::where('auth_token', $request->session()->get('authToken'))->count()))
        ) {
            return Redirect::route('error');
        }

        return $next($request);
    }
}
