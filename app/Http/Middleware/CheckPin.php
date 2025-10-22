<?php

namespace App\Http\Middleware;

use App\Models\Person;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CheckPin
{
    public function handle(Request $request): JsonResponse
    {
        $id = $request->input('user');
        $pin = $request->input('pin');

        $person = Person::findOrFail(1)
            ->where('pin', $pin)
            ->where('id', $id)
            ->first();

        if(!$person)
            return response()->json(['status' => 'error', 'message' => 'Invalid PIN'], 401);

        if ($person->auth_token == null) {
            $person->generateAuthToken();
            $person->save();
        }

        return response()->json(['status' => 'success','first_time' => $person->first_time_login, 'token' => $person->auth_token], 200);
    }
}
