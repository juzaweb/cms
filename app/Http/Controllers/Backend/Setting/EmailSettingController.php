<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Models\Configs;
use App\Models\Email\EmailTemplates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailSettingController extends Controller
{
    public function index() {
        return view('backend.setting.email.index', [
            'title' => trans('app.email_setting')
        ]);
    }
    
    public function sendEmailTest(Request $request) {
        $this->validateRequest([
            'email' => 'required|email',
        ], $request, [
            'email' => trans('app.email'),
        ]);
        
        $emails = [$request->post('email')];
        $subject = 'Test email';
        
        Mail::send('emails.email_test', [], function ($message) use ($emails, $subject) {
            $message->to($emails)->subject($subject);
        });
    
        if (Mail::failures()) {
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
