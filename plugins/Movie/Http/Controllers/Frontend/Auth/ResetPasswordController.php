<?php

namespace Plugins\Movie\Http\Controllers\Frontend\Auth;

use Plugins\Movie\Models\PasswordReset;
use App\Core\User;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;

class ResetPasswordController extends BackendController
{
    public function index($token)
    {
        PasswordReset::where('token', $token)
            ->firstOrFail();
        
        return view('auth.reset_password', [
            'token' => $token
        ]);
    }
    
    public function handle($token, Request $request)
    {
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
