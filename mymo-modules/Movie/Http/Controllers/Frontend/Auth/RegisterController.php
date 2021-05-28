<?php

namespace App\Core\Http\Controllers\Frontend\Auth;

use App\Core\Events\RegisterSuccess;
use App\Core\User;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;

class RegisterController extends FrontendController
{
    public function index()
    {
    
    }
    
    public function register(Request $request)
    {
        if (!get_config('user_registration')) {
            return response()->json([
                'status' => 'error',
                'message' => trans('app.registration_has_been_locked'),
            ]);
        }
        
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:users,email|max:250',
            'password' => 'required|string|max:32|min:6',
        ], $request, [
            'name' => trans('app.name'),
            'email' => trans('app.email'),
            'password' => trans('app.password'),
        ]);
    
        if (get_config('google_recaptcha')) {
            $this->validateRequest([
                'recaptcha' => 'required|recaptcha',
            ], $request);
        }
        
        $model = new User();
        $model->fill($request->all());
        $model->setAttribute('password', \Hash::make($request->post('password')));
        
        if (get_config('user_verification')) {
            $model->setAttribute('status', 2);
            $model->setAttribute('verification_token', generate_token($model->email));
        }
        
        $model->save();
    
        if (!get_config('user_verification')) {
            \Auth::loginUsingId($model->id, true);
        }
        
        event(new RegisterSuccess($model));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.registered_successfully'),
        ]);
    }
}
