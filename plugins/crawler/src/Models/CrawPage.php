<?php

namespace Juzaweb\Crawler\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Crawler\ModelsPage
 *
 * @property int $id
 * @property string $list_url
 * @property string|null $list_url_page
 * @property string $element_item
 * @property int $template_id
 * @property int $channel_id
 * @property int $category_id
 * @property int $next_page
 * @property int $status
 * @property string $crawler_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereElementItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereCrawDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereListUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereListUrlPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereNextPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Juzaweb\Crawler\Models\CrawTemplate|null $template
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereCrawlerDate($value)
 * @property array $category_ids
 * @method static \Illuminate\Database\Eloquent\Builder|CrawPage whereCategoryIds($value)
 */
class CrawPage extends Model
{
    protected $table = 'crawler_pages';

    protected $fillable = [
        'list_url',
        'list_url_page',
        'next_page',
        'element_item',
        'template_id',
        'category_ids',
        'status',
        'crawler_date',
    ];

    public $casts = [
        'category_ids' => 'array'
    ];
    
    public function template()
    {
        return $this->hasOne(CrawTemplate::class, 'id', 'template_id');
    }
    
    public function category()
    {
        return $this->hasOne('Juzaweb\Crawler\Models\Category', 'id', 'category_id');
    }
}
