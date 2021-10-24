<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    /**
     * @inheritDoc
     */
    protected $table = 'persons';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'course',
        'image_url',
        'is_tutor',
        'is_special'
    ];

    /**
     * buy an give article
     *
     * @param  Article $article
     * @return void
     */
    public function buyArticle(Article $article)
    {
        ArticleActionLog::create([
            'person_id' => $this->id,
            'article_id' => $article->id,
        ]);
    }

    /**
     * cancel an article by given article action log
     *
     * @param  ArticleActionLog $articleActionLog
     * @return bool
     */
    public function cancelArticle(ArticleActionLog $articleActionLog)
    {
        if ($articleActionLog->cancelUntil->addSeconds(10) > now()) {
            $articleActionLog->delete();
        }
    }
}
