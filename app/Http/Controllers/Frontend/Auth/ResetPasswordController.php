<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    public function index($token) {
        try {
            $decrypt = json_decode(\Crypt::decryptString($token));
        }
        catch (\Exception $exception) {
            \Log::error($exception->getFile() . ' - Line '. $exception->getLine() .':' . $exception->getMessage());
            return abort(404);
        }
        
        return view('themes.mymo.auth.reset_password', [
            'decrypt' => $decrypt
        ]);
    }
    
    public function handle($token, Request $request) {
        try {
    
            $decrypt = json_decode(\Crypt::decryptString($token));
            if (empty($decrypt->email)) {
                return response()->json([
                    'status' => 'error',
                    'message' => trans('app.error'),
                ]);
            }
            
            $this->validateRequest([
                'password' => 'required|string|max:32|min:6|confirmed',
                'password_confirmation' => 'required|string|max:32|min:6'
            ], $request, [
                'password' => trans('app.new_password'),
                'password_confirmation' => trans('app.confirm_password')
            ]);
    
            $password = $request->post('password');
            User::where('email', '=', $decrypt->email)
                ->update([
                    'password' => \Hash::make($password),
                ]);
    
            return response()->json([
                'status' => 'success',
                'message' => trans('app.change_password_successfully'),
            ]);
        }
        catch (\Exception $exception) {
            \Log::error($exception->getFile() . ' - Line '. $exception->getLine() .':' . $exception->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => trans('app.error'),
            ]);
        }
    }
}
