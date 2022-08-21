<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Juzaweb\Backend\Repositories\UserRepository;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\CMS\Models\User;
use OpenApi\Annotations as OA;

class UserController extends ApiController
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/admin/users",
     *      tags={"Admin / Users"},
     *      summary="Get list users",
     *      operationId="admin.user.index",
     *      @OA\Parameter(ref="#/components/parameters/query_limit"),
     *      @OA\Parameter(ref="#/components/parameters/query_keyword"),
     *      @OA\Response(response=200, ref="#/components/responses/success_list"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function index(Request $request): JsonResponse
    {
        $this->checkPermission($request, 'index', [User::class]);

        $query = $this->userRepository->query();

        $limit = $this->getQueryLimit($request);

        $rows = $query->paginate(
            $limit,
            [
                'id',
                'name',
                'avatar',
                'email',
                'status',
                'created_at',
            ]
        );

        return $this->restPaginate($rows);
    }

    /**
     * @OA\Get(
     *      path="/api/admin/users/{id}",
     *      tags={"Admin / Users"},
     *      summary="Get user by id",
     *      operationId="admin.user.show",
     *      @OA\Parameter(ref="#/components/parameters/id_in_path"),
     *      @OA\Response(response=200, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=404, ref="#/components/responses/error_404"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        $this->checkPermission($request, 'edit', [$user]);

        return $this->restSuccess($user);
    }
}
