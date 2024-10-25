<?php

namespace App\Http\Middleware;

use App\Models\Person;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use IPTools\IP;
use IPTools\Range;
use Symfony\Component\HttpFoundation\Response;

class VpnOrPerson
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // either APP_IS_VPN must be set to true or the request ip must be in the APP_VPN_IP cidr range
        if (env('APP_IS_VPN')) {
            return $next($request);
        }
        if (env('APP_VPN_IP') && array_key_exists("HTTP_X_REAL_IP", $_SERVER)) {
            $app_vpn_ip = Range::parse(env('APP_VPN_IP'));
            if ($app_vpn_ip->contains(new IP($_SERVER['HTTP_X_REAL_IP']))) {
                return $next($request);
            }
        }
        if (!$request->session()->missing('authToken')) {
            return $next($request);
        }
        if (Person::where('auth_token', $request->session()->get('authToken'))->count()) {
            return $next($request);
        }

        return $next($request);
    }
}
