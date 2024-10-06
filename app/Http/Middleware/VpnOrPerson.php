<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Person;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VpnOrPerson
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // skip if not in production
        if (! env('APP_IS_VPN') && ($request->session()->missing('authToken') ||
            ! Person::where('auth_token', $request->session()->get('authToken'))->count())
        ) {
            return Redirect::route('error');
        }

        return $next($request);
    }
}
