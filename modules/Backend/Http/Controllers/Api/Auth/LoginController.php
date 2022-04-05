<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Http\Controllers\ApiController;

class LoginController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

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
     *      @OA\Response(
     *          response=200,
     *          description="Read success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="bool", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items( type="object" )
     *              ),
     *              @OA\Property( property="message", type="string", example=""),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(type="object")
     *      ),
     *      @OA\Response(response=500, description="Internal server error")
     *  )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->restFail($validator->errors(), 'Validation Error.');
        }

        if (! $token = Auth::guard('api')->attempt([
            'email' => $request->post('email'),
            'password' => $request->post('password'),
        ])) {
            return $this->restFail(['error' => 'Unauthorised'], 'Unauthorised.');
        }

        return $this->respondWithToken($token);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return $this->restSuccess([], 'Successfully logged out');
    }

    protected function respondWithToken($token)
    {
        return $this->restSuccess([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ], 'Successfully login');
    }
}
