<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\User;

class VerificationController extends Controller
{
    public function index($token) {
        $user = User::where('verification_token', '=', $token)
            ->where('status', '=', 2)
            ->firstOrFail(['id']);
    
        User::where('id', '=', $user->id)->update([
            'status' => 1,
            'verification_token' => null,
        ]);
        
        \Auth::loginUsingId($user->id);
    
        return view('themes.mymo.message', [
            'title' => trans('app.verified_success'),
            'description' => trans('app.verified_success_description'),
        ]);
    }
}
