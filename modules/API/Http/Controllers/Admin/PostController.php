<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Juzaweb\API\Http\Requests\Post\StoreRequest;
use Juzaweb\API\Http\Requests\Post\UpdateRequest;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\CMS\Repositories\Criterias\FilterCriteria;
use Juzaweb\CMS\Repositories\Criterias\SearchCriteria;
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
     *      path="/api/admin/post-type/{type}",
     *      tags={"Admin / Post Type"},
     *      summary="Get list post type items",
     *      operationId="admin.post-type.type.index",
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
    public function index(Request $request, $type): JsonResponse
    {
        $this->checkPermission($request, 'index', [Post::class, $type]);

        //$this->postRepository->pushCriteria(new SearchCriteria($request));

        //$this->postRepository->pushCriteria(FilterCriteria::class);

        $query = $this->postRepository->query()->where('type', '=', $type);

        $limit = $this->getQueryLimit($request);

        $rows = $query->paginate(
            $limit,
            [
                'id',
                'title',
                'status',
                'views',
                'thumbnail',
                'slug',
                'type',
                'created_at',
            ]
        );

        return $this->restPaginate($rows);
    }

    /**
     * @OA\Get(
     *      path="/api/admin/post-type/{type}/{id}",
     *      tags={"Admin / Post Type"},
     *      summary="Get post type data by id",
     *      operationId="admin.post-type.type.show",
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
    public function show(Request $request, $type, $id): JsonResponse
    {
        $model = $this->postRepository->query()
            ->where('type', '=', $type)
            ->where('id', '=', $id)
            ->firstOrFail();

        $this->checkPermission($request, 'show', [$model, $type]);

        return $this->restSuccess($model);
    }

    /**
     * @OA\Post(
     *      path="/api/admin/post-type/{type}",
     *      tags={"Admin / Post Type"},
     *      summary="Create Post Type",
     *      operationId="admin.post-type.type.store",
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
    public function store(StoreRequest $request, $type): JsonResponse
    {
        $this->checkPermission($request, 'create', [Post::class, $type]);

        $model = $this->postRepository->create($request->all());

        return $this->restSuccess($model, '', 201);
    }

    /**
     * @OA\Put(
     *      path="/api/admin/post-type/{type}/{id}",
     *      tags={"Admin / Post Type"},
     *      summary="Update Post Type",
     *      operationId="admin.post-type.type.update",
     *      @OA\Parameter(
     *          name="type",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="id",
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
     *      @OA\Response(response=200, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=422, ref="#/components/responses/error_422"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function update(UpdateRequest $request, $type, $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        $this->checkPermission($request, 'edit', [$post, $type]);

        $model = $this->postRepository->update($request->all(), $id);

        return $this->restSuccess($model);
    }

    /**
     * @OA\Delete(
     *      path="/api/admin/post-type/{type}/{id}",
     *      tags={"Admin / Post Type"},
     *      summary="Delete Post Type",
     *      operationId="admin.post-type.type.destroy",
     *      @OA\Parameter(
     *          name="type",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response=200, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=422, ref="#/components/responses/error_422"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function destroy(Request $request, $type, $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        $this->checkPermission($request, 'delete', [$post, $type]);

        $this->postRepository->delete($id);

        return $this->restSuccess([], 'Delete successful.');
    }
}
