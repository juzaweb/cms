<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
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
    
        return view('themes.mymo.auth.verified_success', [
            'title' => trans('app.user_e_mail_verification')
        ]);
    }
}
