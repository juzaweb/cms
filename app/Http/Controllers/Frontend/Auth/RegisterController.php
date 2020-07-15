<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function index() {
    
    }
    
    public function register(Request $request) {
        $this->validateRequest([
            'email' => 'required|email',
            'password' => 'required|string|max:32|min:6|confirmed',
            'password_confirmation' => 'required|string|max:32|min:6'
        ], $request, [
            'email' => trans('app.email'),
            'password' => trans('app.password'),
            'password_confirmation' => trans('app.confirm_password'),
        ]);
        
        
    }
}
