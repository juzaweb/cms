<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\Backend\Repositories\TaxonomyRepository;
use Juzaweb\CMS\Facades\Facades;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class TaxonomyController extends FrontendController
{
    public function __construct(
        protected PostRepository $postRepository,
        protected TaxonomyRepository $taxonomyRepository
    ) {
    }

    public function index(...$slug): string|\Inertia\Response
    {
        $taxSlug = Arr::get($slug, 1);
        $currentPage = Arr::get($slug, count($slug) - 1);
        if (str_contains($currentPage, 'page-')) {
            $currentPage = (int) str_replace('page-', '', $currentPage);
        } else {
            $currentPage = null;
        }

        abort_unless($taxSlug, 404);

        $taxonomy = $this->taxonomyRepository->findBySlug($taxSlug);

        abort_if($taxonomy === null, 404);

        Facades::$isTaxonomyPage = true;

        Facades::$taxonomy = $taxonomy;

        $title = $taxonomy->getName();

        $posts = $this->postRepository->frontendListByTaxonomyPaginate(
            get_config('posts_per_page', 12),
            $taxonomy->id,
            $currentPage
        );

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

        $page = PostResourceCollection::make($posts)->response()->getData(true);

        //$taxonomy = (new TaxonomyResource($taxonomy))->toArray(request());

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
