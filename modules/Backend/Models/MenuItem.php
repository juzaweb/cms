<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Collection;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\QueryCache\QueryCacheable;

/**
 * Juzaweb\Backend\Models\MenuItem
 *
 * @property int $id
 * @property int $menu_id
 * @property int|null $parent_id
 * @property string $name
 * @property string $model_class
 * @property int $model_id
 * @property string|null $link
 * @property string $type
 * @property string|null $icon
 * @property string $target
 * @property-read \Juzaweb\Backend\Models\Menu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereModelClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereType($value)
 * @property string $group
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereMenuKey($value)
 * @property string $box_key
 * @property string $label
 * @property int $num_order
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereBoxKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereNumOrder($value)
 * @property-read \Juzaweb\Backend\Models\Taxonomy|null $post
 * @property-read \Juzaweb\Backend\Models\Taxonomy|null $taxonomy
 * @property-read \Illuminate\Database\Eloquent\Collection|MenuItem[] $children
 * @property-read int|null $children_count
 * @property-read MenuItem|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|MenuItem[] $recursiveChildren
 * @property-read int|null $recursive_children_count
 * @mixin \Eloquent
 */
class MenuItem extends Model
{
    use QueryCacheable;

    public $timestamps = false;

    public string $cachePrefix = 'menu_items_';

    protected $table = 'menu_items';

    protected $fillable = [
        'label',
        'menu_id',
        'parent_id',
        'model_id',
        'link',
        'type',
        'icon',
        'target',
        'model_class',
        'model_id',
        'box_key',
        'num_order',
    ];

    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function taxonomy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Taxonomy::class, 'model_id', 'id')->where(
            'model_class',
            '=',
            'Juzaweb\\Models\\Taxonomy'
        );
    }

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Taxonomy::class, 'model_id', 'id')->where(
            'model_class',
            '=',
            'Juzaweb\\Models\\Post'
        );
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function recursiveChildren(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->children()->with(
            [
                'recursiveChildren' => fn ($q) => $q->cacheFor(
                    config('juzaweb.performance.query_cache.lifetime')
                )
            ]
        );
    }

    /**
     * @return Collection
     */
    public function menuBox(): Collection
    {
        return HookAction::getMenuBox($this->box_key);
    }

    public function isActive(): bool
    {
        return request()->url() == $this->link;
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'menu_items',
        ];
    }
}
