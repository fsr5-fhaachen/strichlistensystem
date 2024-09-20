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
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
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
