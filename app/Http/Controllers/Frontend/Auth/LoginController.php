<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index() {
    
    }
    
    public function login(Request $request) {
        $this->validateRequest([
            'email' => 'required|email',
            'password' => 'required',
        ], $request, [
            'email' => trans('app.email'),
            'password' => trans('app.password'),
        ]);
        
        if (get_config('google_recaptcha')) {
            $this->validateRequest([
                'recaptcha' => 'required|recaptcha',
            ], $request);
        }
        
        $user_exists = User::where('email', '=', $request->post('email'))
            ->where('status', '=', 1)
            ->exists();
        
        if ($user_exists) {
            if (\Auth::attempt($request->only(['email', 'password']), 1)) {
                return response()->json([
                    'status' => 'success',
                    'message' => trans('app.logged_successfully'),
                ]);
            }
        }
        
        return response()->json([
            'status' => 'error',
            'message' => trans('app.email_or_password_is_incorrect'),
        ]);
     }
    
    public function logout() {
        if (\Auth::check()) {
            \Auth::logout();
        }
        
        return redirect()->route('home');
    }
}
