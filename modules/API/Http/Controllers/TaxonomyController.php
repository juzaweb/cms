<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Juzaweb\Backend\Http\Resources\PostCollection;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\Backend\Repositories\TaxonomyRepository;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\CMS\Repositories\Criterias\FilterCriteria;
use Juzaweb\CMS\Repositories\Criterias\SearchCriteria;
use Juzaweb\CMS\Repositories\Criterias\SortCriteria;

class TaxonomyController extends ApiController
{
    public function __construct(
        protected TaxonomyRepository $taxonomyRepository,
        protected PostRepository $postRepository
    ) {
    }

    public function index(Request $request, string $type, string $taxonomy): AnonymousResourceCollection
    {
        $queries = $request->all();
        $queries['post_type'] = $type;
        $queries['taxonomy'] = $taxonomy;

        $this->taxonomyRepository->pushCriterias(
            [
                SearchCriteria::make($queries),
                SortCriteria::make($queries),
                FilterCriteria::make($queries),
            ]
        );

        $paginate = $this->taxonomyRepository->frontendListPaginate($this->getQueryLimit($request));

        return TaxonomyResource::collection($paginate);
    }

    public function show(Request $request, string $type, string $taxonomy, string $slug):
    JsonResource
    {
        $queries = $request->all();
        $queries['post_type'] = $type;
        //$queries['taxonomy'] = $taxonomy;

        $this->taxonomyRepository->pushCriteria(FilterCriteria::make($queries));

        $data = $this->taxonomyRepository->frontendDetail($slug);

        if ($withParents = (bool) $request->get('with-parents', 0)) {
            $data->load('recursiveParents');
        }

        return TaxonomyResource::make($data)->withParents($withParents);
    }

    public function posts(Request $request, string $type, string $taxonomy, string $slug): PostCollection
    {
        $taxonomy = $this->taxonomyRepository->findBySlug($slug);

        $queries = $request->query();
        $queries['type'] = $type;

        $this->postRepository->pushCriteria(new SearchCriteria($queries));
        $this->postRepository->pushCriteria(new FilterCriteria($queries));
        $this->postRepository->pushCriteria(new SortCriteria($queries));

        $limit = $this->getQueryLimit($request);

        $rows = $this->postRepository->frontendListByTaxonomyPaginate(
            $limit,
            $taxonomy->id
        );

        return new PostCollection($rows);
    }
}
