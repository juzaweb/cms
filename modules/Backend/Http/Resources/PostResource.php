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

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $taxonomies = TaxonomyResource::collection($this->taxonomies)
            ->toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'description' => $this->description,
            'content' => $this->getContent(),
            'thumbnail' => $this->getThumbnail(),
            'url' => $this->getLink(),
            'views' => $this->getViews(),
            'type' => $this->type,
            'slug' => $this->slug,
            'status' => $this->status,
            'rating' => $this->rating,
            'total_rating' => $this->total_rating,
            'total_comment' => $this->total_comment,
            'metas' => $this->json_metas,
            'author' => [
                'name' => $this->getCreatedByName(),
                'avatar' => $this->getCreatedByAvatar(),
            ],
            'created_at' => jw_date_format($this->created_at),
            'updated_at' => jw_date_format($this->updated_at),
            'taxonomies' => $taxonomies
        ];
    }
}
