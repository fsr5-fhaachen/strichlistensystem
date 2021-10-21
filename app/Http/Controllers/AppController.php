<?php

namespace App\Http\Controllers;

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
        return Inertia::render('App/Index');
    }
}
