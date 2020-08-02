<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Models\Configs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemSettingController extends Controller
{
    public function index() {
        return view('backend.setting.system.index', [
            'title' => trans('app.system_setting')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'title' => 'required|string|max:300',
            'description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:300',
            'logo' => 'required|string|max:300',
            'icon' => 'required|string|max:300',
            'banner' => 'nullable|string|max:300',
            'user_registration' => 'required|in:0,1',
            'user_verification' => 'required|in:0,1',
            'google_recaptcha' => 'required|in:0,1',
            'google_recaptcha_key' => 'required_if:google_recaptcha,!=,0|string|max:300',
            'google_recaptcha_secret' => 'required_if:google_recaptcha,!=,0|string|max:300',
            'player_watermark' => 'required|in:0,1',
            'player_watermark_logo' => 'nullable',
        ], $request, [
            'title' => trans('app.home_title'),
            'description' => trans('app.home_description'),
            'keywords' => trans('app.keywords'),
            'logo' => trans('app.logo'),
            'icon' => trans('app.icon'),
            'banner' => trans('app.banner'),
            'user_registration' => trans('app.user_registration'),
            'user_verification' => trans('app.user_e_mail_verification'),
            'google_recaptcha' => trans('app.google_recaptcha'),
            'google_recaptcha_key' => trans('app.google_recaptcha_key'),
            'google_recaptcha_secret' => trans('app.google_recaptcha_secret'),
            'player_watermark' => trans('app.player_watermark'),
            'player_watermark_logo' => trans('app.player_watermark_logo'),
        ]);
        
        $configs = $request->only(Configs::getConfigs());
        foreach ($configs as $key => $config) {
            Configs::setConfig($key, $config);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting'),
        ]);
    }
}
