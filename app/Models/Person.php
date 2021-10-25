<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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
     * @param  string $ip
     * 
     * @return void
     */
    public function buyArticle(Article $article, string $ip)
    {
        ArticleActionLog::create([
            'person_id' => $this->id,
            'article_id' => $article->id,
            'ip' => $ip,
        ]);
    }

    /**
     * cancel an article by given article action log
     *
     * @param  ArticleActionLog $articleActionLog
     * 
     * @return bool
     */
    public function cancelArticle(ArticleActionLog $articleActionLog)
    {
        if ($articleActionLog->cancelUntil->addSeconds(10) > now()) {
            $articleActionLog->delete();
        }
    }

    /**
     * generate an auth token
     *
     * @return string
     */
    public function generateAuthToken()
    {
        $this->auth_token = bin2hex(random_bytes(32));
        $this->save();

        return $this->auth_token;
    }

    /**
     * create a new auth link
     *
     * @return string
     */
    public function createAuthLink()
    {
        $this->generateAuthToken();

        return route('person.authWithToken', [
            'id' => $this->id,
            'token' => $this->auth_token
        ]);
    }
}
