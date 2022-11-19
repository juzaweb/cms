<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Facades\Facades;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class TaxonomyController extends FrontendController
{
    public function index(...$slug): string
    {
        $taxSlug = $slug[1] ?? null;
        $taxonomy = Taxonomy::where('slug', $taxSlug)
            ->firstOrFail();

        Facades::$isTaxonomyPage = true;

        Facades::$taxonomy = $taxonomy;

        $title = $taxonomy->getName();
        $postType = $taxonomy->getPostType('model');
        $posts = $postType::selectFrontendBuilder()
            ->whereTaxonomy($taxonomy->id)
            ->paginate(get_config('posts_per_page', 12));

        $template = get_name_template_part(
            Str::singular($taxonomy->post_type),
            'taxonomy'
        );

        $viewName = apply_filters(
            'taxonomy.get_view_name',
            "theme::template-parts.{$template}",
            $taxonomy,
            $template
        );

        if (!view()->exists(theme_viewname($viewName))) {
            $viewName = 'theme::index';
        }

        $page = PostResourceCollection::make($posts)
            ->response()
            ->getData(true);

        $taxonomy = (new TaxonomyResource($taxonomy))->toArray(request());

        return $this->view(
            $viewName,
            compact(
                'title',
                'taxonomy',
                'page',
                'template'
            )
        );
    }
}
