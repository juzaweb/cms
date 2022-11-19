<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return $this->collection->map(
            function ($item) use ($request) {
                $taxonomies = TaxonomyResource::collection($item->taxonomies)->toArray($request);

                return [
                    'id' => $item->id,
                    'title' => $item->getTitle(),
                    'description' => $item->description,
                    'thumbnail' => $item->getThumbnail(true),
                    'url' => $item->getLink(),
                    'views' => $item->getViews(),
                    'type' => $item->type,
                    'slug' => $item->slug,
                    'status' => $item->status,
                    'rating' => $item->rating,
                    'total_rating' => $item->total_rating,
                    'total_comment' => $item->total_comment,
                    'metas' => $item->json_metas,
                    'author' => [
                        'name' => $item->getCreatedByName(),
                        'avatar' => $item->getCreatedByAvatar(),
                    ],
                    'created_at' => jw_date_format($item->created_at),
                    'updated_at' => jw_date_format($item->updated_at),
                    'taxonomies' => $taxonomies
                ];
            }
        )->toArray();
    }
}
