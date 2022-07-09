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
use Juzaweb\API\Http\Requests\Post\StoreRequest;
use Juzaweb\API\Http\Requests\Post\UpdateRequest;
use Juzaweb\Backend\Http\Resources\PostCollection;
use Juzaweb\Backend\Http\Resources\PostResource;
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
     *      summary="Get news data by slug",
     *      operationId="v1.news.findBySlug",
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

        return new PostResource($model);
    }

    /**
     * @OA\Post(
     *      path="/api/post-type/{type}",
     *      tags={"Post Type"},
     *      summary="Create Post Type",
     *      operationId="api.v1.post-type.type.store",
     *      @OA\Parameter(
     *          name="type",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title"},
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Title"
     *                  ),
     *                  @OA\Property(
     *                      property="content",
     *                      type="string",
     *                      description="content"
     *                  ),
     *                  @OA\Property(
     *                      property="grecaptcha_token",
     *                      type="string",
     *                      description="(Optional) Token of Google Recaptcha V3"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=422, ref="#/components/responses/error_422"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function store(StoreRequest $request): PostResource
    {
        $model = $this->postRepository->create($request->all());

        return new PostResource($model);
    }

    public function update(UpdateRequest $request, $id): PostResource
    {
        $model = $this->postRepository->update($request->all(), $id);

        return new PostResource($model);
    }
}
