<?php

namespace Juzaweb\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Juzaweb\Modules\Core\Contracts\Sitemapable;
use Juzaweb\Modules\Core\Enums\PostStatus;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\Core\Traits\HasDescription;
use Juzaweb\Modules\Core\Traits\HasSeoMeta;
use Juzaweb\Modules\Core\Traits\HasSitemap;
use Juzaweb\Modules\Core\Traits\HasSlug;

class PostTranslation extends Model implements Sitemapable
{
    use HasAPI, HasDescription, HasSeoMeta, HasSlug, HasSitemap;

    protected $table = 'post_translations';

    protected $fillable = [
        'title',
        'content',
        'description',
        'slug',
        'locale',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function scopeForSitemap(Builder $builder): Builder
    {
        // Default: return all records ordered by updated_at
        return $builder
            ->join('posts', 'post_translations.post_id', '=', 'posts.id')
            ->where('posts.status', PostStatus::PUBLISHED)
            ->select(['post_translations.*'])
            ->cacheDriver('file')
            ->cacheFor(3600 * 24)
            ->orderBy('updated_at', 'desc');
    }

    public function seoMetaFill(): array
    {
        return [
            'title' => $this->title,
            'description' => seo_string($this->content, 160),
        ];
    }

    /**
     * When invalidating automatically on update, you can specify
     * which tags to invalidate.
     */
    public function getCacheTagsToInvalidateOnUpdate(
        ?string $relation = null,
        ?Collection $pivotedModels = null
    ): array {
        $table = $this->getTable();

        return [
            ...$this->getCacheBaseTags(),
            $table.':'.$this->id,
            $table.':'.$this->slug,
        ];
    }

    public function getUrl(): string
    {
        if ($this->locale != setting('language')) {
            return home_url("{$this->locale}/post/{$this->slug}");
        }

        return home_url("post/{$this->slug}");
    }
}
