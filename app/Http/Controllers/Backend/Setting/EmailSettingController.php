<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Models\Configs;
use App\Models\EmailTemplates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailSettingController extends Controller
{
    public function index() {
        return view('backend.setting.email.index', [
            'title' => trans('app.comment_setting')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'mail_host' => 'required|string|max:300',
            'mail_driver' => 'required|string|max:300',
            'mail_port' => 'required|string|max:300',
            'mail_username' => 'nullable|string|max:300',
            'mail_password' => 'nullable|string|max:300',
            'mail_encryption' => 'nullable|string|max:300',
            'mail_from_name' => 'required|string|max:300',
            'mail_from_address' => 'required|string|max:300',
        ], $request, [
            'mail_host' => trans('app.mail_host'),
            'mail_driver' => trans('app.mail_driver'),
            'mail_port' => trans('app.mail_port'),
            'mail_username' => trans('app.mail_username'),
            'mail_password' => trans('app.mail_password'),
            'mail_encryption' => trans('app.mail_encryption'),
            'mail_from_name' => trans('app.mail_from_name'),
            'mail_from_address' => trans('app.mail_from_address'),
        ]);
        
        $configs = $request->only([
            'mail_host',
            'mail_driver',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_name',
            'mail_from_address',
        ]);
        
        try {
            foreach ($configs as $key => $config) {
                Configs::setConfig($key, (string) $config);
            }
        }
        catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.email'),
        ]);
    }
    
    public function sendEmailTest(Request $request) {
        $this->validateRequest([
            'email' => 'required|email',
        ], $request, [
            'email' => trans('app.email'),
        ]);
    
        \Config::set('mail.host', Configs::getConfig('mail_host'));
        \Config::set('mail.driver', Configs::getConfig('mail_driver'));
        \Config::set('mail.port', Configs::getConfig('mail_port'));
        \Config::set('mail.username', Configs::getConfig('mail_username'));
        \Config::set('mail.password', Configs::getConfig('mail_password'));
        \Config::set('mail.encryption', Configs::getConfig('mail_encryption'));
        \Config::set('mail.from.name', Configs::getConfig('mail_from_name'));
        \Config::set('mail.from.address', Configs::getConfig('mail_from_address'));
    
        (new \Illuminate\Mail\MailServiceProvider(app()))->register();
        
        $emails = [$request->post('email')];
        $subject = 'Test email';
        
        Mail::send('emails.email_test', [], function ($message) use ($emails, $subject) {
            $message->to($emails)->subject($subject);
        });
    
        if (Mail::failures()) {
            dd(Mail::failures());
            return response()->json([
                'status' => 'error',
                'message' => Mail::failures()[0],
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.send_email_successfully'),
            'redirect' => route('admin.setting.email'),
        ]);
    }
}
