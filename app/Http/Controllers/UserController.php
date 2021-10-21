<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class UserController extends Controller
{
    /**
     * show specific user
     *
     * @param  int $id
     * @return \Inertia\Response
     */
    public function show(int $id)
    {
        $user = [
            'id' => $id,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'course' => 'INF',
            'img' =>  'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            'isTutor' =>  true,
            'isSpecial' =>  true,
        ];

        return Inertia::render('User/Show', [
            'user' => $user,
        ]);
    }
}
