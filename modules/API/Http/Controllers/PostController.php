<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\API\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Resources\PostCollection;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\CMS\Repositories\Criterias\FilterCriteria;
use Juzaweb\CMS\Repositories\Criterias\SearchCriteria;
use Juzaweb\CMS\Repositories\Criterias\SortCriteria;

class PostController extends ApiController
{
    public function __construct(protected PostRepository $postRepository)
    {
    }

    public function index(Request $request, $type): PostCollection
    {
        $queries = $request->query();
        $queries['type'] = $type;
        $this->postRepository->pushCriteria(new SearchCriteria($queries));
        $this->postRepository->pushCriteria(new FilterCriteria($queries));
        $this->postRepository->pushCriteria(new SortCriteria($queries));

        $limit = $this->getQueryLimit($request);

        $rows = $this->postRepository->frontendListPaginate($limit);

        return new PostCollection($rows);
    }

    public function show($type, $slug): PostResource
    {
        $model = $this->postRepository->createFrontendDetailBuilder()
            ->where('type', '=', $type)
            ->where('slug', '=', $slug)
            ->firstOrFail();

        return new PostResource($model);
    }

    public function related(Request $request, $type, $slug): PostCollection
    {
        $model = $this->postRepository->createFrontendDetailBuilder()
            ->where('type', '=', $type)
            ->where('slug', '=', $slug)
            ->firstOrFail();

        $queries = $request->query();
        $queries['type'] = $type;

        $this->postRepository->pushCriteria(new SearchCriteria($queries));
        $this->postRepository->pushCriteria(new FilterCriteria($queries));
        $this->postRepository->pushCriteria(new SortCriteria($queries));

        $limit = $this->getQueryLimit($request);

        $rows = $this->postRepository->frontendListByTaxonomyPaginate(
            $limit,
            collect($model->json_taxonomies)->pluck('id')->toArray()
        );

        return new PostCollection($rows);
    }
}
