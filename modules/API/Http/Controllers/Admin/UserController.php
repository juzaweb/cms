<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Requests\User\StoreUserRequest;
use Juzaweb\Backend\Http\Requests\User\UpdateUserRequest;
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

    /**
     * @OA\Post(
     *      path="/api/admin/users",
     *      tags={"Admin / Users"},
     *      summary="Store user",
     *      operationId="admin.user.store",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name","email","password"},
     *                  @OA\Property(property="name",
     *                      type="string",
     *                      example="string",
     *                      description="name"
     *                  ),
     *                  @OA\Property(property="email",
     *                      type="string",
     *                      example="string@gmail.com",
     *                      description="email"
     *                  ),
     *                  @OA\Property(property="password",
     *                      type="string",
     *                      example="string",
     *                      description="password"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=422, ref="#/components/responses/error_422"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->checkPermission($request, 'create', [User::class]);

        $name = $request->post('name');

        $email = $request->post('email');

        $password = $request->post('password');

        DB::beginTransaction();
        try {
            $user = $this->userRepository->create(
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make(Str::random())
                ]
            );

            $user->setAttribute('password', Hash::make($password));

            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->restSuccess(
            $user,
            'Create user successfully.',
            201
        );
    }

    /**
     * @OA\Put(
     *      path="/api/admin/users/{id}",
     *      tags={"Admin / Users"},
     *      summary="Update user",
     *      operationId="admin.user.update",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name","password"},
     *                  @OA\Property(property="name",
     *                      type="string",
     *                      example="string",
     *                      description="name"
     *                  ),
     *                  @OA\Property(property="password",
     *                      type="string",
     *                      example="string",
     *                      description="password"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=422, ref="#/components/responses/error_422"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        $this->checkPermission($request, 'edit', [$user]);

        $name = $request->post('name');

        $password = $request->post('password');

        DB::beginTransaction();
        try {
            $user = $this->userRepository->update(
                [
                    'name' => $name,
                    'password' => Hash::make($password)
                ],
                $id
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->restSuccess(
            $user,
            'Update user successfully.'
        );
    }
}
