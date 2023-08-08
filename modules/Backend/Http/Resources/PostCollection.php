<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(
            function ($item) {
                $taxonomies = TaxonomyResource::collection($item->taxonomies);

                return [
                    'id' => $item->id,
                    'title' => $item->getTitle(),
                    'description' => $item->description,
                    'thumbnail' => $item->getThumbnail(),
                    'origin_thumbnail' => $item->thumbnail,
                    'thumbnail_without_resize' => $item->getThumbnail(false),
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
