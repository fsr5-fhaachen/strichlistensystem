<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Inertia\Inertia;


class PersonController extends Controller
{
    /**
     * show specific person
     *
     * @param  int $id
     * @return \Inertia\Response
     */
    public function show(int $id)
    {
        $person = Person::findOrFail($id);

        return Inertia::render('Person/Show', [
            'person' => $person,
        ]);
    }
}
