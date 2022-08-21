<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\API\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Backend\Http\Requests\API\Auth\LoginRequest;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\CMS\Models\User;
use OpenApi\Annotations as OA;

class LoginController extends ApiController
{
    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      tags={"Auth"},
     *      summary="User login",
     *      operationId="api.auth.login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"email","password"},
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
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();

        $token = $user->createToken('auth_token');

        return $this->respondWithToken($token, $user);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(
            Auth::guard('api')->refresh(),
            Auth::guard('api')->user()
        );
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      tags={"Auth"},
     *      summary="User logout",
     *      security={{"sanctum":{}}},
     *      operationId="api.auth.logout",
     *      @OA\Response(response=201, ref="#/components/responses/success_detail"),
     *      @OA\Response(response=422, ref="#/components/responses/error_422"),
     *      @OA\Response(response=500, ref="#/components/responses/error_500")
     *  )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->restSuccess([], 'Successfully logged out.');
    }

    protected function respondWithToken($token, User $user): JsonResponse
    {
        return $this->restSuccess(
            [
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => $token->token->expires_at,
                'user' => new UserResource($user),
            ],
            'Successfully login.'
        );
    }
}
