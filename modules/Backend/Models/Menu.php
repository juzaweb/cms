<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 *
 * Created by JUZAWEB.
 * Date: 8/12/2021
 * Time: 12:38 PM
 */

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Arr;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\QueryCache\QueryCacheable;
use Juzaweb\CMS\Traits\UseUUIDColumn;

/**
 * Juzaweb\Backend\Models\Menu
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\MenuItem[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereSiteId($value)
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUuid($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use QueryCacheable, UseUUIDColumn;

    public string $cachePrefix = 'menus_';

    protected $table = 'menus';

    protected $fillable = [
        'name',
    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }

    public function syncItems(array $items, $parentId = null): array
    {
        $order = 1;
        $result = [];
        foreach ($items as $item) {
            $result = array_merge(
                $result,
                $this->saveItem($item, $order, $parentId)
            );
        }

        $this->items()
            ->whereNotIn('id', $result)
            ->delete();

        return $result;
    }

    public function saveItem(array $item, &$order, $parentId = null): array
    {
        $result = [];
        $menuBox = HookAction::getMenuBox($item['box_key']);
        if (empty($menuBox)) {
            return $result;
        }

        $menuBox = $menuBox->get('menu_box');
        $data = $menuBox->getData($item);
        $data['parent_id'] = $parentId;
        $data['menu_id'] = $this->id;
        $data['num_order'] = $order;
        $data['box_key'] = $item['box_key'];
        $data['target'] = $item['target'] ?? '_self';

        $model = $this->items()->updateOrCreate(
            [
                'id' => $item['id'] ?? null,
            ],
            $data
        );

        $order++;
        $result[$model->id] = $model->id;

        if ($children = Arr::get($item, 'children')) {
            foreach ($children as $child) {
                $result = array_merge(
                    $result,
                    $this->saveItem($child, $order, $model->id)
                );
            }
        }

        return $result;
    }

    public function getLocation(): ?string
    {
        $locations = get_theme_config('nav_location');
        return array_search($this->id, $locations) ?: null;
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'menus',
        ];
    }
}
