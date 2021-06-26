<?php

namespace Mymo\Backend\Http\Controllers\Backend\Email;

use Mymo\Backend\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Mymo\Email\EmailService;

class EmailController extends BackendController
{
    public function index()
    {
        $config = get_config('email', []);
        return view('mymo::backend.email.index', [
            'title' => trans('mymo::app.email_setting'),
            'config' => $config,
        ]);
    }
    
    public function save(Request $request)
    {
        $email = $request->post('email');
        set_config('email', $email);
        
        return $this->success([
            'message' => trans('mymo::app.save_successfully')
        ]);
    }
    
    public function sendTestMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $email = $request->post('email');
        EmailService::make()
            ->setEmails($email)
            ->setSubject('Send email test for {name}')
            ->setBody('Hello {name}, This is the test email')
            ->setParams(['name' => Auth::user()->name])
            ->send();

        return $this->success([
            'message' => trans('mymo::app.send_mail_successfully')
        ]);
    }
}
