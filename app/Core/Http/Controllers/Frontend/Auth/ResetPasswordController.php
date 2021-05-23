<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    public function index($token) {
        PasswordReset::where('token', $token)
            ->firstOrFail();
        
        return view('themes.mymo.auth.reset_password', [
            'token' => $token
        ]);
    }
    
    public function handle($token, Request $request) {
        $this->validateRequest([
            'password' => 'required|string|max:32|min:6|confirmed',
            'password_confirmation' => 'required|string|max:32|min:6'
        ], $request, [
            'password' => trans('app.new_password'),
            'password_confirmation' => trans('app.confirm_password')
        ]);
    
        $reset_password = PasswordReset::where('token', $token)
            ->firstOrFail();
        $password = $request->post('password');
        User::where('email', '=', $reset_password->email)
            ->update([
                'password' => \Hash::make($password),
            ]);
        
        PasswordReset::where('token', $token)->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.change_password_successfully'),
        ]);
    }
}
