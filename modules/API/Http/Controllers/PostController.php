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
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\CMS\Http\Controllers\ApiController;
use OpenApi\Annotations as OA;

class PostController extends ApiController
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/post-type/{type}",
     *      tags={"Post Type"},
     *      summary="Get list post type items",
     *      operationId="v1.post-type.type.index",
     *      @OA\Parameter(
     *          name="type",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(ref="#/components/parameters/query_limit"),
     *      @OA\Parameter(ref="#/components/parameters/query_keyword"),
     *      @OA\Response(response=200, ref="#/components/responses/success_list"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function index(Request $request, $type): PostCollection
    {
        $this->checkPermission($request, 'index', [Post::class, $type]);

        //$this->postRepository->pushCriteria(new SearchCriteria($request));

        //$this->postRepository->pushCriteria(new FilterCriteria($request));

        $query = $this->postRepository->createSelectFrontendBuilder()
            ->where('type', '=', $type);

        $limit = $this->getQueryLimit($request);

        $rows = $query->paginate($limit);

        return new PostCollection($rows);
    }

    /**
     * @OA\Get(
     *      path="/api/post-type/{type}/{id}",
     *      tags={"Post Type"},
     *      summary="Get post type data by id",
     *      operationId="v1.post-type.type.show",
     *      @OA\Parameter(
     *          name="type",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(ref="#/components/parameters/id_in_path"),
     *      @OA\Response(response=200, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=404, ref="#/components/responses/error_404"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function show(Request $request, $type, $id): PostResource
    {
        $model = $this->postRepository->createSelectFrontendBuilder()
            ->where('type', '=', $type)
            ->where('id', '=', $id)
            ->firstOrFail();

        $this->checkPermission($request, 'show', [$model, $type]);

        return new PostResource($model);
    }
}
