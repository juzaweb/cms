<?php

namespace Juzaweb\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Modules\Core\Contracts\Sitemapable;
use Juzaweb\Modules\Core\FileManager\Traits\HasMedia;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\Core\Traits\HasSeoMeta;
use Juzaweb\Modules\Core\Traits\HasSitemap;
use Juzaweb\Modules\Core\Traits\HasSlug;
use function Juzaweb\Modules\Admin\Models\Posts\website_id;

class CategoryTranslation extends Model implements Sitemapable
{
    use HasAPI, HasMedia, HasSeoMeta, HasSlug, HasSitemap;

    protected $table = 'post_category_translations';

    protected $fillable = [
        'name',
        'description',
        'slug',
        'locale',
        'post_category_id',
        'website_id',
    ];

    public function scopeForSitemap(Builder $builder): Builder
    {
        return $builder->join(
            'post_categories',
            'post_category_translations.post_category_id',
            '=',
            'post_categories.id'
        )
            ->select('post_category_translations.*')
            ->where('post_category_translations.website_id'
            ->cacheFor(3600 * 24)
            ->cacheDriver('file')
            ->orderBy('post_category_translations.updated_at', 'desc');
    }

    public function getUrl(): string
    {
        if ($this->locale != setting('language')) {
            return home_url("{$this->locale}/post/category/{$this->slug}");
        }

        return home_url("post/category/{$this->slug}");
    }

    public function seoMetaFill(): array
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
        ];
    }
}
