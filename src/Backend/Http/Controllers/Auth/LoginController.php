<?php

namespace Mymo\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mymo\Core\Models\User;
use Illuminate\Support\Facades\Auth;
use Mymo\Core\Traits\ResponseMessage;

class LoginController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        do_action('auth.login.index');
        
        //
        
        return view('mymo_core::auth.login', [
            'title' => trans('mymo_core::app.login')
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
        $user = User::whereEmail($email)->first(['status', 'is_admin']);
        
        if (empty($user)) {
            return $this->error([
                'message' => trans('mymo_core::message.login_form.login_failed')
            ]);
        }
        
        if ($user->status != 'active') {
            return $this->error([
                'message' => trans('mymo_core::message.login_form.user_is_banned')
            ]);
        }
        
        if (Auth::attempt([
            'email' => $email,
            'password' => $password
        ], $remember)) {
            do_action('auth.login.success', Auth::user());

            return $this->success([
                'message' => trans('mymo_core::app.login_successfully'),
                'redirect' => $user->is_admin ? route('admin.dashboard') : '/'
            ]);
        }
    
        do_action('auth.login.failed');
        
        return $this->error(trans('mymo_core::message.login_form.login_failed'));
    }
    
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        
        return redirect()->to('/');
    }
}
