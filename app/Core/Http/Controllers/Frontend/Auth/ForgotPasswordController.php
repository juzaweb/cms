<?php

namespace App\Core\Http\Controllers\Frontend\Auth;

use App\Core\Models\Email\EmailList;
use App\Core\Models\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use App\Core\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function handle(Request $request) {
        $this->validateRequest([
            'email' => 'required',
        ], $request, [
            'email' => trans('app.email')
        ]);
        
        $email = $request->post('email');
        $user = $this->checkEmailExists($email);
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => trans('app.email_does_not_exist'),
            ]);
        }
        
        $token = generate_token($email);
        $model = PasswordReset::firstOrNew(['email' => $email]);
        $model->email = $email;
        $model->token = $token;
        $model->save();
        
        $mail = new EmailList();
        $mail->emails = $email;
        $mail->params = json_encode([
            'name' => $user->name,
            'email' => $user->email,
            'url' => route('password.reset', [$token]),
        ]);
    
        $mail->sendByTemplate('forgot_password');
        return response()->json([
            'status' => 'success',
            'redirect' => route('password.forgot.success'),
        ]);
    }
    
    public function message() {
        return view('themes.mymo.message', [
            'title' => trans('app.forgot_message'),
            'description' => trans('app.forgot_message_description'),
        ]);
    }
    
    protected function checkEmailExists($email) {
        return User::where('email', $email)
            ->where('status', 1)
            ->first();
    }
}
