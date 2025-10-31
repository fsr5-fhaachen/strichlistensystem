<?php

namespace App\Http\Middleware;

use App\Models\Person;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie("token") ?? $_COOKIE["token"] ?? null;
        $person = Person::findOrFail($request->route('id'));

        if (!$person || $token !== $person->auth_token) {
            return Redirect::route('landingPage');
        }

        return $next($request);
    }
}
