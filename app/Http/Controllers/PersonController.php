<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleActionLog;
use App\Models\Person;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Http\Request;


class PersonController extends Controller
{
    /**
     * validate auth token
     *
     * @param  Request $request
     * @param  Person $person
     * 
     * @return null|\Illuminate\Http\RedirectResponse
     */
    public function validateAuthToken(Request $request, Person $person)
    {
        if ($request->session()->missing('authToken')) {
            return;
        }

        $authTokenPerson = Person::where('auth_token', $request->session()->get('authToken'))->first();

        if ($person->id != $authTokenPerson->id) {
            return Redirect::route('error');
        }
    }

    /**
     * show specific person
     *
     * @param  Request $request
     * @param  int $id
     * 
     * @return \Inertia\Response
     */
    public function show(Request $request, int $id)
    {
        $person = Person::findOrFail($id);
        if ($this->validateAuthToken($request, $person)) {
            return $this->validateAuthToken($request, $person);
        }

        $articles = Article::orderBy('show_order')->get();
        $articleActionLogs = ArticleActionLog::withTrashed()->where('person_id', '=', $id)->orderBy('created_at', 'desc')->limit(20)->get();

        return Inertia::render('Person/Show', [
            'person' => $person,
            'articles' => $articles,
            'articleActionLogs' => $articleActionLogs,
            'isPersonAuth' => $request->session()->missing('authToken') ? false : true,
        ]);
    }

    /**
     * buy an article for a user
     *
     * @param  Request $request
     * @param  int $id
     * @param  int $articleID
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buy(Request $request, int $id, int $articleID)
    {
        $person = Person::findOrFail($id);
        if ($this->validateAuthToken($request, $person)) {
            return $this->validateAuthToken($request, $person);
        }

        $article = Article::findOrFail($articleID);

        $person->buyArticle($article, $request->ip());

        return Redirect::route('person.show', ['id' => $id]);
    }

    /**
     * cancel an article for a user by article log id
     *
     * @param  Request $request
     * @param  int $id
     * @param  int $articleActionLogId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request, int $id, int $articleActionLogId)
    {
        $person = Person::findOrFail($id);
        if ($this->validateAuthToken($request, $person)) {
            return $this->validateAuthToken($request, $person);
        }

        $articleActionLog = ArticleActionLog::findOrFail($articleActionLogId);

        if ($person->id == $articleActionLog->person_id) {
            $person->cancelArticle($articleActionLog);
        }

        return Redirect::route('person.show', ['id' => $id]);
    }

    /**
     * create new auth link for a person
     *
     * @param  Request $request
     * @param  int $id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateAuthLink(Request $request, int $id)
    {
        $person = Person::findOrFail($id);
        if ($this->validateAuthToken($request, $person)) {
            return $this->validateAuthToken($request, $person);
        }

        return response()->json([
            'authLink' => $person->createAuthLink()
        ]);
    }

    /**
     * auth a person with token
     *
     * @param  Request $request
     * @param  int $id
     * @param  string $token
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authWithToken(Request $request, int $id, string $token)
    {
        $person = Person::findOrFail($id);

        if ($person->auth_token != $token) {
            return Redirect::route('error');
        }

        $request->session()->put('authToken', $person->auth_token);

        return Redirect::route('person.show', ['id' => $id]);
    }
}
