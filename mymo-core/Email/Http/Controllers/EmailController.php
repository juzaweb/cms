<?php

namespace Mymo\Email\Http\Controllers;

use Mymo\Core\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Mymo\Email\EmailService;

class EmailController extends BackendController
{
    public function index()
    {
        return view('emailtemplate::email.index', [
            'title' => trans('mymo_core::app.email_setting'),
        ]);
    }
    
    public function save(Request $request)
    {
        $settings = $this->getSettings();
        foreach ($settings as $setting) {
            if ($request->has($setting)) {
                set_config($setting, $request->post($setting));
            }
        }
        
        return $this->success(
            trans('mymo_core::app.save_successfully')
        );
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
    }
    
    protected function getSettings()
    {
        return [
            'email_setting',
            'email_host',
            'email_port',
            'email_encryption',
            'email_username',
            'email_password',
            'email_from_address',
            'email_from_name',
        ];
    }
}
