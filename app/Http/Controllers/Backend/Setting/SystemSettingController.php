<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Models\Configs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemSettingController extends Controller
{
    public function index($form = null) {
        if (empty($form)) {
            $form = 'general';
        }
        
        if (!view()->exists('backend.setting.system.form.' . $form)) {
            $form = 'general';
        }
        
        $form_content = view('backend.setting.system.form.' . $form)->render();
        
        return view('backend.setting.system.index', [
            'title' => trans('app.system_setting'),
            'form' => $form,
            'form_content' => $form_content,
            'settings' => $this->settingList(),
        ]);
    }
    
    public function save(Request $request) {
        $configs = $request->only(Configs::getConfigs());
        foreach ($configs as $key => $config) {
            if ($request->has($key)) {
                Configs::setConfig($key, $config);
            }
        }
    
        $form = $request->post('form');
        if (empty($form)) {
            $form = 'general';
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.form', [$form]),
        ]);
    }
    
    public function saveBlockIp(Request $request) {
        $this->validateRequest([
            'block_ip_status' => 'required',
            'block_ip_type' => 'required',
            'block_ip_list' => 'required',
        ], $request, [
            'block_ip_status' => trans('app.block_ip_status'),
            'block_ip_type' => trans('app.block_ip_type'),
            'block_ip_list' => trans('app.block_ip_list'),
        ]);
        
        $block_ip_status = $request->post('block_ip_status');
        $block_ip_type = $request->post('block_ip_type');
        $block_ip_list = $request->post('block_ip_list');
        
        Configs::setConfig('block_ip_status', $block_ip_status);
        Configs::setConfig('block_ip_type', $block_ip_type);
        Configs::setConfig('block_ip_list', implode(',', $block_ip_list));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.form', ['blockip']),
        ]);
    }
    
    protected function settingList() {
        return [
            'general' => trans('app.site_info'),
            'recaptcha' => trans('app.google_recaptcha'),
            'player' => trans('app.player'),
            'blockip' => trans('app.block_ip'),
            'paid-members' => trans('app.paid_members'),
        ];
    }
}
