<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\API\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Juzaweb\API\Http\Requests\Auth\LoginRequest;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\CMS\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;
use OpenApi\Annotations as OA;

class LoginController extends ApiController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();

        $token = $user->createToken('auth_token');

        return $this->respondWithToken($token, $user);
    }

    public function profile(Request $request): JsonResponse
    {
        $user = $request->user('api');

        $token = $user->token();

        return $this->respondWithToken(
            new PersonalAccessTokenResult($request->bearerToken(), $token),
            $user
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
        $request->user('api')->token()->delete();

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
