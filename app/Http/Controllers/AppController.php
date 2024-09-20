<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Utils\Telegram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    /**
     * list all users
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $persons = Person::where('is_disabled', '=', false)->orderBy('firstname')->orderBy('lastname')->get();

        return Inertia::render('App/Index', [
            'persons' => $persons,
        ]);
    }

    /**
     * logout and destroy all sessions
     */
    public function logout(Request $request)
    {
        $authTokenPerson = Person::where('auth_token', $request->session()->get('authToken'))->first();

        Telegram::info('User logged out', $request, $authTokenPerson);

        $request->session()->flush();

        return Inertia::render('App/Logout');
    }

    /**
     * error page
     */
    public function error(Request $request)
    {
        $request->session()->flush();

        return Inertia::render('App/Error');
    }
}
