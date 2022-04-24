<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class TaxonomyController extends FrontendController
{
    public function index(...$slug)
    {
        $taxSlug = $slug[1] ?? null;
        $taxonomy = Taxonomy::where('slug', $taxSlug)
            ->firstOrFail();

        $title = $taxonomy->getName();
        $postType = $taxonomy->getPostType('model');
        $posts = $postType::selectFrontendBuilder()
            ->whereTaxonomy($taxonomy->id)
            ->paginate();

        $template = get_name_template_part(
            Str::singular($taxonomy->post_type),
            'taxonomy'
        );

        $page = PostResource::collection($posts)
            ->response()
            ->getData(true);

        $taxonomy = (new TaxonomyResource($taxonomy))->toArray(redirect());

        return $this->view('theme::template-parts.' . $template, compact(
            'title',
            'taxonomy',
            'page',
            'template'
        ));
    }
}
