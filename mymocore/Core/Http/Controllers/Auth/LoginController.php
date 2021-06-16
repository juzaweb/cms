<?php

namespace Mymo\Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mymo\Core\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        do_action('auth.login.index');
        
        //
        
        return view('mymo_core::auth.login', [
            'title' => trans('mymo_core::app.sign-in')
        ]);
    }
    
    public function login(Request $request)
    {
        // Login handle action
        do_action('auth.login.handle', $request);
    
        // Validate login
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:32',
        ]);
        
        $email = $request->post('email');
        $password = $request->post('password');
        $remember = filter_var($request->post('remember'), FILTER_VALIDATE_BOOLEAN);
        
        $user = User::whereEmail($email)->first(['status']);
        
        if (!$user) {
            return $this->error(trans('mymo_core::message.login-form.login-failed'));
        }
        
        if ($user->status != 'active') {
            return $this->error(trans('mymo_core::message.login-form.user-is-banned'));
        }
        
        if (Auth::attempt([
            'email' => $email,
            'password' => $password
        ], $remember)) {
            do_action('auth.login.success', Auth::user());

            return $this->success([
                'message' => trans('mymo_core::app.login_successfully')
            ]);
        }
    
        do_action('auth.login.failed');
        
        return $this->error(trans('mymo_core::message.login-form.login-failed'));
    }
    
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        
        return redirect()->to('/');
    }
}
