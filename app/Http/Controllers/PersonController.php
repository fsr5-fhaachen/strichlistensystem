<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleActionLog;
use App\Models\Person;
use App\Utils\Telegram;
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
     * @param  bool $enableLog
     * 
     * @return null|\Illuminate\Http\RedirectResponse
     */
    public function validateAuthToken(Request $request, Person $person, bool $enableLog = true)
    {
        if ($request->session()->missing('authToken')) {
            return;
        }

        $authTokenPerson = Person::where('auth_token', $request->session()->get('authToken'))->first();

        if ($person->id != $authTokenPerson->id) {
            if ($enableLog) {
                Telegram::warning('Try to access "*' . $person->fullname . '*"\'s (ID: `' . $person->id . '`) page with an invalid auth token', $request, $authTokenPerson);
            }

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
            return $this->validateAuthToken($request, $person, false);
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
            return $this->validateAuthToken($request, $person, false);
        }

        $article = Article::findOrFail($articleID);

        $person->buyArticle($article, $request->ip());

        Telegram::info('Bought the article "*' . $article->name . '*" (ID: `' . $article->id . '`)', $request, $person);

        $count = ArticleActionLog::where('person_id', $person->id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();

        if ($count >= 6) {
            Telegram::warning('Bought *' . $count . '* articles in the last 5 minutes', $request, $person);
        }

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
            return $this->validateAuthToken($request, $person, false);
        }

        $articleActionLog = ArticleActionLog::findOrFail($articleActionLogId);

        if ($person->id == $articleActionLog->person_id) {
            $person->cancelArticle($articleActionLog);

            Telegram::info('Cancel the article "*' . $articleActionLog->article->name . '*" (ID: `' . $articleActionLog->article->id . '`)', $request, $person);

            $count = ArticleActionLog::withTrashed()->where('person_id', $person->id)
                ->where('deleted_at', '>=', now()->subMinutes(5))
                ->count();

            if ($count >= 3) {
                Telegram::warning('Cancel *' . $count . '* articles in the last 5 minutes', $request, $person);
            }
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
            return $this->validateAuthToken($request, $person, false);
        }

        Telegram::info('Generate an auth link for "*' . $person->fullname . '*" (ID: `' . $person->id . '`)', $request, $person);

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

        Telegram::info('Auth "*' . $person->fullname . '*" (ID: `' . $person->id . '`)', $request, $person);

        return Redirect::route('person.show', ['id' => $id]);
    }
}
