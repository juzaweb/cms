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

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Taxonomy;

class TaxonomyResource extends JsonResource
{
    protected bool $withParents = false;

    public function withParents(bool $withParents): static
    {
        $this->withParents = $withParents;

        return $this;
    }

    public function toArray($request): array
    {
        $results = [
            'id' => $this->id,
            'name' => $this->name,
            'taxonomy' => $this->taxonomy,
            'singular' => Str::singular($this->taxonomy),
            'slug' => $this->slug,
            'level' => $this->level,
            'total_post' => $this->total_post,
            'thumbnail' => $this->getThumbnail(),
            'url' => $this->getLink(),
        ];

        if ($this->withParents) {
            $parents = [];
            $this->mapRecursiveParents($this->resource, $parents);
            $results['parents'] = array_reverse($parents);
        }

        return $results;
    }

    protected function mapRecursiveParents(Taxonomy $taxonomy, &$results): void
    {
        if ($taxonomy->recursiveParents) {
            $results[] = TaxonomyResource::make($taxonomy->recursiveParents);

            if ($taxonomy->recursiveParents->recursiveParents) {
                $this->mapRecursiveParents($taxonomy->recursiveParents->recursiveParents, $results);
            }
        }
    }
}
