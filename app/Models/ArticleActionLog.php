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
     * @inheritDoc
     */
    protected $fillable = [
        'person_id',
        'article_id'
    ];

    /**
     * @inheritDoc
     */
    protected $appends = [
        'article',
        'cancelUntil',
        'cancelUntilTimestamp',
        'createdAtFormatted',
        'deletedAtFormatted'
    ];

    /**
     * get the article that this action log belongs to
     *
     * @return Article
     */
    public function getArticleAttribute()
    {
        return Article::find($this->article_id);
    }

    /**
     * time until which the article action log can be cancelled
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getCancelUntilAttribute()
    {
        return $this->created_at->addSeconds(60);
    }

    /**
     * time stamp until which the article action log can be cancelled
     *
     * @return Integer
     */
    public function getCancelUntilTimestampAttribute()
    {
        return $this->getCancelUntilAttribute()->timestamp;
    }

    /**
     * get created at timestamp as formatted date
     *
     * @return string
     */
    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->format('d.m.Y \u\m H:i:s \U\h\r');
    }

    /**
     * get deleted at timestamp as formatted date
     *
     * @return string
     */
    public function getDeletedAtFormattedAttribute()
    {
        return Carbon::parse($this->deleted_at)->format('d.m.Y \u\m H:i:s \U\h\r');
    }
}
