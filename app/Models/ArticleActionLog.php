<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleActionLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'person_id',
        'article_id',
        'ip',
    ];

    /**
     * {@inheritDoc}
     */
    protected $appends = [
        'article',
        'cancelUntil',
        'cancelUntilTimestamp',
        'createdAtFormatted',
        'deletedAtFormatted',
        'person',
    ];

    /**
     * get the article that this action log belongs to
     */
    public function getArticleAttribute(): Article
    {
        return Article::find($this->article_id);
    }

    /**
     * time until which the article action log can be cancelled
     */
    public function getCancelUntilAttribute(): \Illuminate\Support\Carbon
    {
        return $this->created_at->addSeconds(60);
    }

    /**
     * time stamp until which the article action log can be cancelled
     */
    public function getCancelUntilTimestampAttribute(): int
    {
        return $this->getCancelUntilAttribute()->timestamp;
    }

    /**
     * get created at timestamp as formatted date
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('d.m.Y \u\m H:i:s \U\h\r');
    }

    /**
     * get deleted at timestamp as formatted date
     */
    public function getDeletedAtFormattedAttribute(): string
    {
        return Carbon::parse($this->deleted_at)->format('d.m.Y \u\m H:i:s \U\h\r');
    }

    /**
     * get the person that this action log belongs to
     */
    public function getPersonAttribute(): Person
    {
        return Person::find($this->person_id);
    }
}
