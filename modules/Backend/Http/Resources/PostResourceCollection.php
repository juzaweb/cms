<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
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
            function ($item) {
                $taxonomies = collect($item->json_taxonomies)->map(
                    function ($tax) {
                        unset($tax['total_post']);
                        $tax['url'] = url(parse_url($tax['url'])['path']);
                        return $tax;
                    }
                );

                return [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'title' => $item->getTitle(),
                    'description' => $item->description,
                    'thumbnail' => $item->getThumbnail(true),
                    'origin_thumbnail' => $item->thumbnail,
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
                    'humans_created_at' => $item->created_at?->diffForHumans(),
                    'updated_at' => jw_date_format($item->updated_at),
                    'taxonomies' => $taxonomies,
                ];
            }
        )->toArray();
    }
}
