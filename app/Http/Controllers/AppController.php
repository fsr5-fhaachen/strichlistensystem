<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Utils\Telegram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppController extends Controller
{
    /**
     * list all users
     */
    public function index(): Response
    {
        $persons = Person::where('is_disabled', '=', false)->orderBy('firstname')->orderBy('lastname')->get();

        return Inertia::render('App/Index', [
            'persons' => $persons,
        ]);
    }

    /**
     * logout and destroy all sessions
     */
    public function logout(Request $request): Response
    {
        $authTokenPerson = Person::where('auth_token', $request->session()->get('authToken'))->first();

        Telegram::info('User logged out', $request, $authTokenPerson);

        $request->session()->flush();

        return Inertia::render('App/Logout');
    }

    /**
     * error page
     */
    public function error(Request $request): Response
    {
        $request->session()->flush();

        return Inertia::render('App/Error');
    }
}
