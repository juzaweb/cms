<?php

namespace Juzaweb\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Juzaweb\Modules\Blog\Database\Factories\CategoryFactory;
use Juzaweb\Modules\Core\FileManager\Traits\HasMedia;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Support\Traits\MenuBoxable;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\Core\Traits\HasThumbnail;
use Juzaweb\Modules\Core\Traits\Translatable;
use Juzaweb\Modules\Core\Traits\UsedInFrontend;
use Juzaweb\Modules\Core\Translations\Contracts\Translatable as TranslatableContract;

class Category extends Model implements TranslatableContract
{
    use HasAPI,
        HasFactory,
        HasUuids,
        MenuBoxable,
        Translatable,
        UsedInFrontend,
        HasMedia,
        HasThumbnail;

    protected $table = 'post_categories';

    protected $translationForeignKey = 'post_category_id';

    protected $fillable = [
        'parent_id',
        'thumbnail',
    ];

    public $translatedAttributes = [
        'name',
        'description',
        'slug',
        'locale',
    ];

    protected $appends = [
        'thumbnail',
    ];

    public $mediaChannels = ['thumbnail'];

    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id')->with('children');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category', 'post_category_id', 'post_id');
    }

    public function scopeWhereInFrontend(Builder $builder): Builder
    {
        return $builder->withTranslation(null, null, true);
    }

    public function scopeWhereRoot(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }

    public function scopeWhereInMenuBox(Builder $builder): Builder
    {
        return $builder->withTranslation();
    }

    public function getEditUrl(): string
    {
        return route('admin.post-categories.edit', [$this->id]);
    }

    public function getUrl(): string
    {
        return home_url("post/category/{$this->slug}", $this->locale);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
