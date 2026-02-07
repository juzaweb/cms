<?php

namespace Juzaweb\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Juzaweb\Modules\Blog\Database\Factories\PostFactory;
use Juzaweb\Modules\Core\Enums\PostStatus;
use Juzaweb\Modules\Core\FileManager\Traits\HasMedia;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Support\Traits\HasComments;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\Core\Traits\HasContent;
use Juzaweb\Modules\Core\Traits\HasCreator;
use Juzaweb\Modules\Core\Traits\HasFrontendUrl;
use Juzaweb\Modules\Core\Traits\HasTags;
use Juzaweb\Modules\Core\Traits\HasThumbnail;
use Juzaweb\Modules\Core\Traits\Translatable;
use Juzaweb\Modules\Core\Traits\UsedInFrontend;
use Juzaweb\Modules\Core\Translations\Contracts\Translatable as TranslatableContract;

class Post extends Model implements TranslatableContract
{
    use HasAPI,
        HasFactory,
        HasUuids,
        Translatable,
        HasTags,
        HasComments,
        HasThumbnail,
        HasMedia,
        UsedInFrontend,
        HasFrontendUrl,
        HasContent,
        HasCreator;

    protected $table = 'posts';

    protected $fillable = [
        'status',
    ];

    protected $casts = [
        'status' => PostStatus::class,
    ];

    public $translatedAttributes = [
        'title',
        'content',
        'description',
        'slug',
        'locale',
    ];

    public $mediaChannels = ['thumbnail'];

    public $translatedAttributeFormats = [
        'content' => 'html',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_category', 'post_id', 'post_category_id');
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_category', 'post_id', 'post_category_id')
            ->take(1);
    }

    public function scopeWhereInFrontend(Builder $builder, bool $cache = true): Builder
    {
        return $builder
            ->withTranslation(null, null, $cache)
            ->with([
                'media' => fn($q) => $q->when($cache, fn($q) => $q->cacheFor(3600))
            ])
            ->where('status', PostStatus::PUBLISHED);
    }

    public function scopeAdditionSearch(Builder $builder, string $keyword): Builder
    {
        return $builder->orWhereHas(
            'translations',
            function (Builder $query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            }
        );
    }

    public function scopeWhereMostPopular(Builder $builder): Builder
    {
        return $builder->orderBy('views', 'desc');
    }

    public function getUrl(): string
    {
        return home_url("post/{$this->slug}", $this->locale);
    }

    /**
     * When invalidating automatically on update, you can specify
     * which tags to invalidate.
     *
     * @param  string|null  $relation
     * @param  Collection|null  $pivotedModels
     * @return array
     */
    public function getCacheTagsToInvalidateOnUpdate(?string $relation = null, ?Collection $pivotedModels = null): array
    {
        $table = $this->getTable();

        return [
            ...$this->getCacheBaseTags(),
            $table . ':' . $this->id,
            $table . ':' . $this->slug,
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
