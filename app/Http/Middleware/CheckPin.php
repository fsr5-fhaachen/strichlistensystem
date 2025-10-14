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

        $person = Person::findOrFail($id)->where('pin', $pin)->first();

        if(!$person)
            return response()->json(['status' => 'error', 'message' => 'Invalid PIN'], 401);

        if ($person->auth_token == null) {
            $person->generateAuthToken();
            $person->save();
        }

        return response()->json(['status' => 'success', 'token' => $person->auth_token], 200);
    }
}
