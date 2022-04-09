<?php

namespace Juzaweb\Crawler\Models;

use Juzaweb\CMS\Models\Language;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\ResourceModel;

/**
 * Juzaweb\Crawler\ModelsTemplate
 *
 * @property int $id
 * @property string $name
 * @property string|null $crawler_thumbnail
 * @property string|null $crawler_title
 * @property string|null $crawler_content
 * @property string $lang
 * @property int $auto_leech
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Crawler\Models\CrawPage[] $pages
 * @property-read int|null $pages_count
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereAutoCraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereCrawContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereCrawThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereCrawTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Crawler\Models\Component[] $components
 * @property-read int|null $components_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Crawler\Models\CrawLink[] $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Crawler\Models\CrawRemoveElement[] $removes
 * @property-read int|null $removes_count
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereAutoLeech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereCrawlerContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereCrawlerThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereCrawlerTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereSiteId($value)
 * @property-read Language|null $language
 * @property int|null $user_id
 * @property string|null $post_status
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate wherePostStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawTemplate whereUserId($value)
 */
class CrawTemplate extends Model
{
    use ResourceModel;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';

    protected $table = 'crawler_templates';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    
    public function pages()
    {
        return $this->hasMany(CrawPage::class, 'template_id', 'id');
    }
    
    public function links()
    {
        return $this->hasMany(CrawLink::class, 'template_id', 'id');
    }
    
    public function components()
    {
        return $this->hasMany(Component::class, 'template_id', 'id');
    }
    
    public function removes()
    {
        return $this->hasMany(CrawRemoveElement::class, 'template_id', 'id');
    }
    
    public function language()
    {
        return $this->hasOne(Language::class, 'code', 'lang');
    }
}
