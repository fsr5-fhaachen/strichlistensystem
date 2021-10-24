<?php

namespace App\Http\Controllers;

use App\Models\Person;
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
        $persons = Person::orderBy('firstname')->orderBy('lastname')->get();

        return Inertia::render('App/Index', [
            'persons' => $persons,
        ]);
    }
}
