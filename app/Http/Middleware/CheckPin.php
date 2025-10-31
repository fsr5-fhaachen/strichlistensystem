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

        $person = Person::where('pin', $pin)
            ->where('id', $id)
            ->first();

        if (!$person)
            return response()->json(['status' => 'error', 'message' => 'Invalid PIN'], 401);

        if ($person->auth_token == null) {
            $person->generateAuthToken();
            $person->save();
        }

        if (env('APP_DEBUG')) {
            Log::debug('CheckPin Debug', [
                'person_id' => $person->id,
                'token' => $person->auth_token,
                'pin_change_required' => $person->pin_change_required
            ]);
        }

        // Set cookie from backend with Laravel's cookie method (handles encryption properly)
        // Also return token in JSON for debugging
        return response()
            ->json([
                'status' => 'success',
                'pin_change_required' => $person->pin_change_required,
                'token' => $person->auth_token
            ], 200)
            ->cookie('token', $person->auth_token, 60 * 24 * 7, '/', null, false, false);
    }
}

