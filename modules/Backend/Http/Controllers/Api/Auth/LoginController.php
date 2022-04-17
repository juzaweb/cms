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
use Juzaweb\CMS\Http\Controllers\ApiController;

class LoginController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'bail|required|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->restFail($validator->errors(), 'Validation Error.');
        }

        if (! $token = Auth::guard('api')->attempt(
            [
                'email' => $request->post('email'),
                'password' => $request->post('password'),
            ]
        )
        ) {
            return $this->restFail(
                ['error' => 'Unauthorised'],
                'Unauthorised.'
            );
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
        return $this->restSuccess(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            ],
            'Successfully login'
        );
    }
}
