<?php

namespace Mymo\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mymo\Core\Models\User;
use Mymo\Core\Traits\ResponseMessage;
use Mymo\Email\EmailService;

class RegisterController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        if (!get_config('users_can_register', 1)) {
            return abort(403, trans('mymo_core::message.register-form.register-closed'));
        }
        
        do_action('auth.register.index');
        
        return view('mymo_core::auth.register', [
            'title' => trans('mymo_core::app.sign-up')
        ]);
    }
    
    public function register(Request $request)
    {
        do_action('auth.register.handle', $request);
    
        if (!get_config('users_can_register', 1)) {
            return $this->error(trans('mymo_core::message.register-form.register-closed'));
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

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

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

            return $this->success([
                'redirect' => route('auth.register')
            ]);
        }

        do_action('auth.register.success', $user);

        return $this->success([
            'redirect' => route('auth.login')
        ]);
    }
}
