<?php

namespace Mymo\Core\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tadcms\System\Models\User;
use Tadcms\EmailTemplate\EmailService;
use Tadcms\System\Controllers\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        if (!get_config('users_can_register', 1)) {
            return abort(403, trans('tadcms::message.register-form.register-closed'));
        }
        
        do_action('auth.register.index');
        
        return view('tadcms::auth.register', [
            'title' => trans('tadcms::app.sign-up')
        ]);
    }
    
    public function register(Request $request)
    {
        do_action('auth.register.handle', $request);
    
        if (!get_config('users_can_register', 1)) {
            return $this->error(trans('tadcms::message.register-form.register-closed'));
        }
        
        // Validate register
        $request->validate([
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:6|max:32',
        ]);
        
        // Create user
        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
    
            if (get_config('user_confirmation')) {
                $verifyToken = Str::random(32);
                
                $user->update([
                    'status' => 'verification',
                    'verification_token' => $verifyToken,
                ]);
                
                EmailService::make()
                    ->withTemplate('verification')
                    ->setParams([
                        'name' => $name,
                        'email' => $email,
                        'token' => $verifyToken,
                    ])
                    ->send();
                
                return $this->redirect(route('auth.register'));
            }
            
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        
        do_action('auth.register.success', $user);
        
        return $this->redirect(route('auth.login'));
    }
}
