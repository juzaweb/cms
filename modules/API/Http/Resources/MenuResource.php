<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Juzaweb\Backend\Models\Menu;

/**
 * @property Menu $resource
 */
class MenuResource extends JsonResource
{
    public function toArray($request): array
    {
        $this->resource->load(
            [
                'items.recursiveChildren' => fn ($q) => $q->cacheFor(
                    config('juzaweb.performance.query_cache.lifetime')
                )
            ]
        );

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'location' => $this->resource->getLocation(),
            'items' => MenuItemCollection::make($this->resource->items),
        ];
    }
}
