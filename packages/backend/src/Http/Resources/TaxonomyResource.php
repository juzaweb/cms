<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxonomyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'taxonomy' => $this->taxonomy,
            'slug' => $this->slug,
            'level' => $this->level,
            'total_post' => $this->total_post,
            'thumbnail' => $this->getThumbnail(),
            'url' => $this->getLink(),
        ];
    }
}
