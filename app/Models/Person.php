<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $table = 'persons';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'course',
        'img',
        'is_tutor',
        'is_special',
        'is_disabled',
        'auth_token',
    ];

    /**
     * {@inheritDoc}
     */
    protected $appends = [
        'fullName',
        'image',
    ];

    /**
     * get the person's image.
     */
    public function getImageAttribute(): string
    {
        // check if image is set and file exists
        if (! empty($this->img) && Storage::disk('s3')->exists($this->img)) {
            // generate presigned url for s3 with path stored in "img"
            return Storage::disk('s3')->temporaryUrl(
                $this->img,
                now()->addMinutes(60)
            );
        } else {
            // no image is set, return default image
            return '/images/default.jpg';
        }
    }

    /**
     * get the person's full name.
     */
    public function getFullnameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * buy an give article
     */
    public function buyArticle(Article $article, string $ip): void
    {
        ArticleActionLog::create([
            'person_id' => $this->id,
            'article_id' => $article->id,
            'ip' => $ip,
        ]);
    }

    /**
     * cancel an article by given article action log
     */
    public function cancelArticle(ArticleActionLog $articleActionLog): void
    {
        if ($articleActionLog->cancelUntil->addSeconds(10) > now()) {
            $articleActionLog->delete();
        }
    }

    /**
     * generate an auth token
     */
    public function generateAuthToken(): string
    {
        $this->auth_token = bin2hex(random_bytes(32));
        $this->save();

        return $this->auth_token;
    }

    /**
     * create a new auth link
     */
    public function createAuthLink(): string
    {
        $this->generateAuthToken();

        // generate the route
        $personAuthWithTokenRoute = route('person.authWithToken', [
            'id' => $this->id,
            'token' => $this->auth_token,
        ]);

        // get only the path
        $personAuthWithTokenRoute = parse_url($personAuthWithTokenRoute, PHP_URL_PATH);

        return config('app.public_url').$personAuthWithTokenRoute;
    }
}
