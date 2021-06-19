<?php

namespace Mymo\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Mymo\Core\Models\PasswordReset;
use Mymo\Core\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function index($email, $token)
    {
        do_action('auth.reset-password.index');
        
        $user = User::whereEmail($email)
            ->whereExists(function ($query) use ($email, $token) {
                $query->select(['email'])
                    ->where('email', '=', $email)
                    ->where('token', '=', $token);
            })
            ->firstOrFail();
        
        return view('mymo_core::auth.forgot_password', [
            'user' => $user,
        ]);
    }
    
    public function resetPassword($email, $token, Request $request)
    {
        do_action('auth.reset-password.handle');
    
        $request->validate([
            'password' => 'required|string|min:6|max:32',
            'password_confirmation' => 'required|string|max:32|min:6'
        ]);
        
        $user = User::whereEmail($email)
            ->whereExists(function ($query) use ($email, $token) {
                $query->select(['email'])
                    ->from('password_resets')
                    ->where('email', '=', $email)
                    ->where('token', '=', $token);
            })
            ->firstOrFail();
    
        $passwordReset = PasswordReset::where('email', '=', $email)
            ->where('token', '=', $token)
            ->firstOrFail();
    
        DB::beginTransaction();
        try {
            $user->update([
                'password' => Hash::make($request->post('password'))
            ]);
            
            $passwordReset->delete();
        
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    
        return redirect()->route('auth.login');
    }
}
