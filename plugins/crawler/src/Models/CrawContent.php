<?php

namespace Juzaweb\Crawler\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Crawler\Models\CrawContent
 *
 * @property int $id
 * @property string $url
 * @property string $components
 * @property string $lang
 * @property int $template_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Juzaweb\Crawler\Models\CrawTemplate|null $template
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereComponents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereUrl($value)
 * @mixin \Eloquent
 * @property string $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereThumbnail($value)
 * @property int $link_id
 * @property-read \Juzaweb\Crawler\Models\CrawLink|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereLinkId($value)
 * @property int $page_id
 * @property int $channel_id
 * @property int $category_id
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereSiteId($value)
 * @property array|null $category_ids
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereCategoryIds($value)
 * @property string|null $crawler_thumbnail
 * @property string|null $crawler_title
 * @property string|null $crawler_content
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereCrawlerContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereCrawlerThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawContent whereCrawlerTitle($value)
 */
class CrawContent extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';

    protected $table = 'crawler_contents';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public $casts = [
        'components' => 'array',
        'category_ids' => 'array',
    ];
    
    public function template()
    {
        return $this->belongsTo(CrawTemplate::class, 'template_id', 'id');
    }
    
    public function link()
    {
        return $this->belongsTo(CrawLink::class, 'link_id', 'id');
    }
}
