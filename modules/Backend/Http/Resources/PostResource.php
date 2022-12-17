<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $taxonomies = TaxonomyResource::collection($this->resource->taxonomies)->toArray($request);

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTitle(),
            'description' => $this->resource->description,
            'content' => $this->resource->getContent(),
            'thumbnail' => $this->resource->getThumbnail(false),
            'url' => $this->resource->getLink(),
            'views' => $this->resource->getViews(),
            'type' => $this->resource->type,
            'slug' => $this->resource->slug,
            'status' => $this->resource->status,
            'rating' => $this->resource->rating,
            'total_rating' => $this->resource->total_rating,
            'total_comment' => $this->resource->total_comment,
            'metas' => $this->resource->json_metas,
            'author' => [
                'name' => $this->resource->getCreatedByName(),
                'avatar' => $this->resource->getCreatedByAvatar(),
            ],
            'created_at' => jw_date_format($this->resource->created_at),
            'updated_at' => jw_date_format($this->resource->updated_at),
            'taxonomies' => $taxonomies
        ];
    }
}
