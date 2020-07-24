<?php

namespace App\Http\Controllers\Frontend\Account;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function index() {
        $user = \Auth::user();
        return view('themes.mymo.profile.change_password', [
            'user' => $user
        ]);
    }
    
    public function handle(Request $request) {
        $this->validateRequest([
            'current_password' => 'required|string',
            'password' => 'required|string|max:32|min:6|confirmed',
            'password_confirmation' => 'required|string|max:32|min:6'
        ], $request, [
            'current_password' => trans('app.current_password'),
            'password' => trans('app.new_password'),
            'password_confirmation' => trans('app.confirm_password')
        ]);
        
        $current_password = $request->post('current_password');
        $password = $request->post('password');
        
        if (!\Hash::check($current_password, \Auth::user()->password)) {
            return response()->json([
                'status' => 'error',
                'message' => trans('app.current_password_incorrect'),
            ]);
        }
        
        User::where('id', '=', \Auth::id())
            ->update([
                'password' => \Hash::make($password),
            ]);
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.old_password_incorrect'),
        ]);
    }
}
