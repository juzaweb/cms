<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\RegisterSuccess;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function index() {
    
    }
    
    public function register(Request $request) {
        if (!get_config('user_registration')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration has been locked',
            ]);
        }
        
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|string|max:32|min:6|confirmed',
            'password_confirmation' => 'required|string|max:32|min:6'
        ], $request, [
            'name' => trans('app.name'),
            'email' => trans('app.email'),
            'password' => trans('app.password'),
            'password_confirmation' => trans('app.confirm_password'),
        ]);
        
        $model = new User();
        $model->fill($request->all());
        $model->setAttribute('password', \Hash::make($request->post('password')));
        
        if (get_config('user_verification')) {
            $model->setAttribute('status', 2);
        }
        
        $model->save();
        event(new RegisterSuccess($model));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.registered_successfully'),
        ]);
    }
}
