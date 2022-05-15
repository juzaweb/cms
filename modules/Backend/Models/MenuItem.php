<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Collection;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Model;

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
 * @mixin \Eloquent
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
 */
class MenuItem extends Model
{
    public $timestamps = false;

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

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'model_id', 'id')->where(
            'model_class',
            '=',
            'Juzaweb\\Models\\Taxonomy'
        );
    }

    public function post()
    {
        return $this->belongsTo(Taxonomy::class, 'model_id', 'id')->where(
            'model_class',
            '=',
            'Juzaweb\\Models\\Post'
        );
    }

    /**
     * @return Collection
     */
    public function menuBox()
    {
        $register = HookAction::getMenuBox($this->box_key);

        return $register;
    }

    public function isActive()
    {
        return request()->url() == $this->link;
    }
}
