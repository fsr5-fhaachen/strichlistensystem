<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleActionLog;
use App\Models\Person;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class PersonController extends Controller
{
    /**
     * show specific person
     *
     * @param  int $id
     * 
     * @return \Inertia\Response
     */
    public function show(int $id)
    {
        $person = Person::findOrFail($id);
        $articles = Article::orderBy('show_order')->get();
        $articleActionLogs = ArticleActionLog::withTrashed()->where('person_id', '=', $id)->orderBy('created_at', 'desc')->limit(20)->get();

        return Inertia::render('Person/Show', [
            'person' => $person,
            'articles' => $articles,
            'articleActionLogs' => $articleActionLogs
        ]);
    }

    /**
     * buy an article for a user
     *
     * @param  int $id
     * @param  int $articleID
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buy(int $id, int $articleID)
    {
        $person = Person::findOrFail($id);
        $article = Article::findOrFail($articleID);
        $person->buyArticle($article);

        return Redirect::route('person.show', ['id' => $id]);
    }

    /**
     * cancel an article for a user by article log id
     *
     * @param  int $id
     * @param  int $articleActionLogId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(int $id, int $articleActionLogId)
    {
        $person = Person::findOrFail($id);
        $articleActionLog = ArticleActionLog::findOrFail($articleActionLogId);

        if ($person->id == $articleActionLog->person_id) {
            $person->cancelArticle($articleActionLog);
        }

        return Redirect::route('person.show', ['id' => $id]);
    }
}
