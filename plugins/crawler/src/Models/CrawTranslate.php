<?php

namespace Juzaweb\Crawler\Models;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\Backend\Models\Post;

/**
 * Juzaweb\Crawler\Models\CrawTranslate
 *
 * @property int $id
 * @property int $content_id
 * @property int|null $post_id
 * @property string $lang
 * @property string|null $error
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Juzaweb\Crawler\Models\CrawContent|null $content
 * @property-read \Juzaweb\Crawler\Models\Language|null $language
 * @property-read \Juzaweb\Crawler\Models\Post|null $post
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTranslate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CrawTranslate extends Model
{
    protected $table = 'crawler_translate_histories';
    protected $fillable = [
        'content_id',
        'post_id',
        'lang',
        'status',
        'error',
    ];
    
    public function content()
    {
        return $this->hasOne(CrawContent::class, 'id', 'content_id');
    }
    
    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
    
    public function language()
    {
        return $this->hasOne('Juzaweb\Crawler\Models\Language', 'code', 'lang');
    }
}
