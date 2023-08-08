<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\API\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\Backend\Repositories\UserRepository;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\CMS\Http\Requests\Auth\RegisterRequest;
use OpenApi\Annotations as OA;

class RegisterController extends ApiController
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Post(
     *      path="/api/auth/register",
     *      tags={"Auth"},
     *      summary="User register",
     *      operationId="api.auth.register",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name","email","password","password_confirmation"},
 *                      @OA\Property(property="name",
     *                      type="string",
     *                      example="string",
     *                      description="name"
     *                  ),
     *                  @OA\Property(property="email",
     *                      type="string",
     *                      example="example@gmail.com",
     *                      description="email"
     *                  ),
     *                  @OA\Property(property="password",
     *                      type="string",
     *                      example="password",
     *                      description="password"
     *                  ),
     *                  @OA\Property(property="password_confirmation",
     *                      type="string",
     *                      example="password",
     *                      description="password_confirmation"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=422, ref="#/components/responses/error_422"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        if (! get_config('users_can_register', 1)) {
            return $this->restFail(
                [
                    [
                        'filed' => 'email',
                        'message' => trans('cms::message.register-form.register-closed')
                    ]
                ],
                trans('cms::message.register-form.register-closed')
            );
        }

        $user = $request->createUserFromRequest();

        $token = $user->createToken('auth_token');

        return $this->restSuccess(
            [
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => $token->token->expires_at,
                'user' => new UserResource($user),
            ],
            'Register successfully.'
        );
    }
}
