<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class AppController extends Controller
{
    /**
     * index
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('App/Index');
    }
}
