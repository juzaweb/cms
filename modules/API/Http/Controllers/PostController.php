<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
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

class PostController extends ApiController
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    
    public function index(Request $request, $type): PostCollection
    {
        //$this->postRepository->pushCriteria(new SearchCriteria($request));

        //$this->postRepository->pushCriteria(new FilterCriteria($request));

        $query = $this->postRepository->createSelectFrontendBuilder()
            ->where('type', '=', $type);

        $limit = $this->getQueryLimit($request);

        $rows = $query->paginate($limit);

        return new PostCollection($rows);
    }
    
    public function show(Request $request, $type, $slug): PostResource
    {
        $model = $this->postRepository->createSelectFrontendBuilder()
            ->where('type', '=', $type)
            ->where('slug', '=', $slug)
            ->firstOrFail();

        return new PostResource($model);
    }
}
