<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Article;
use App\Models\ArticleActionLog;
use App\Models\Person;
use App\Utils\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonController extends Controller
{
    /**
     * validate auth token
     */
    public function validateAuthToken(Request $request, Person $person, bool $enableLog = true): RedirectResponse
    {
        if ($request->session()->missing('authToken')) {
            return;
        }

        $authTokenPerson = Person::where('auth_token', $request->session()->get('authToken'))->first();

        if ($person->id != $authTokenPerson->id) {
            if ($enableLog) {
                Telegram::warning('Try to access "*'.$person->fullname.'*"\'s (ID: `'.$person->id.'`) page with an invalid auth token', $request, $authTokenPerson);
            }

            return Redirect::route('error');
        }
    }

    /**
     * show specific person
     */
    public function show(Request $request, int $id): Response
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
     */
    public function buy(Request $request, int $id, int $articleID): RedirectResponse
    {
        $person = Person::findOrFail($id);
        if ($this->validateAuthToken($request, $person)) {
            return $this->validateAuthToken($request, $person, false);
        }

        $article = Article::findOrFail($articleID);

        $amount = $request['amount'];
        if (! is_numeric($amount) || $amount < 1 || $amount > $article->max_order_amount) {
            return Redirect::route('person.show', ['id' => $id]);
        }

        for ($i = 0; $i < $amount; $i++) {
            $person->buyArticle($article, $request->ip());
        }

        Telegram::info('Bought the article "*'.$article->name.'*" ('.$amount.'x) (ID: `'.$article->id.'`)', $request, $person);

        $count = ArticleActionLog::where('person_id', $person->id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();

        if ($count >= 6) {
            Telegram::warning('Bought *'.$count.'* articles in the last 5 minutes', $request, $person);
        }

        return Redirect::route('person.show', ['id' => $id]);
    }

    /**
     * cancel an article for a user by article log id
     */
    public function cancel(Request $request, int $id, int $articleActionLogId): RedirectResponse
    {
        $person = Person::findOrFail($id);
        if ($this->validateAuthToken($request, $person)) {
            return $this->validateAuthToken($request, $person, false);
        }

        $articleActionLog = ArticleActionLog::findOrFail($articleActionLogId);

        if ($person->id == $articleActionLog->person_id) {
            $person->cancelArticle($articleActionLog);

            Telegram::info('Cancel the article "*'.$articleActionLog->article->name.'*" (ID: `'.$articleActionLog->article->id.'`). Bought at "'.$articleActionLog->created_at.'" and canceld at "'.$articleActionLog->deleted_at.'". Could have cancelled by "'.$articleActionLog->cancelUntil.'" (ID: `'.$articleActionLog->id.'`)', $request, $person);

            $count = ArticleActionLog::withTrashed()->where('person_id', $person->id)
                ->where('deleted_at', '>=', now()->subMinutes(5))
                ->count();

            if ($count >= 3) {
                Telegram::warning('Cancel *'.$count.'* articles in the last 5 minutes', $request, $person);
            }
        }

        return Redirect::route('person.show', ['id' => $id]);
    }

    /**
     * create new auth link for a person
     */
    public function generateAuthLink(Request $request, int $id): JsonResponse
    {
        $person = Person::findOrFail($id);
        if ($this->validateAuthToken($request, $person)) {
            return $this->validateAuthToken($request, $person, false);
        }

        Telegram::info('Generate an auth link for "*'.$person->fullname.'*" (ID: `'.$person->id.'`)', $request, $person);

        return response()->json([
            'authLink' => $person->createAuthLink(),
        ]);
    }

    /**
     * auth a person with token
     */
    public function authWithToken(Request $request, int $id, string $token): RedirectResponse
    {
        $person = Person::findOrFail($id);

        if ($person->auth_token != $token) {
            return Redirect::route('error');
        }

        $request->session()->put('authToken', $person->auth_token);

        Telegram::info('Auth "*'.$person->fullname.'*" (ID: `'.$person->id.'`)', $request, $person);

        return Redirect::route('person.show', ['id' => $id]);
    }
}
