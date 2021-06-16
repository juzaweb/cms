<?php

namespace Mymo\Core\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tadcms\System\Models\PasswordReset;
use Tadcms\System\Models\User;
use Tadcms\EmailTemplate\EmailService;
use Tadcms\System\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        do_action('auth.forgot-password.index');
        
        return view('tadcms::auth.forgot_password');
    }
    
    public function forgotPassword(Request $request)
    {
        do_action('auth.forgot-password.handle', $request);
        
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        $email = $request->post('email');
        $user = User::whereEmail($email)->first();
    
        try {
            $resetToken = Str::random(32);
            PasswordReset::create([
                'email' => $request->post('email'),
                'token' => $resetToken,
            ]);
    
            EmailService::make()
                ->withTemplate('reset_password')
                ->setParams([
                    'name' => $user->name,
                    'email' => $email,
                    'token' => $resetToken,
                ])
                ->send();
            
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    
        return $this->redirect(route('auth.forgot-password'));
    }
}
