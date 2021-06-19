<?php

namespace Mymo\Core\Http\Controllers\Backend\Setting;

use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\Config;
use Illuminate\Http\Request;

class SystemSettingController extends BackendController
{
    public function index($form = null)
    {
        if (empty($form)) {
            $form = 'general';
        }
        
        if (!view()->exists('mymo_core::backend.setting.system.form.' . $form)) {
            $form = 'general';
        }
        
        $form_content = view('mymo_core::backend.setting.system.form.' . $form)->render();
        
        return view('mymo_core::backend.setting.system.index', [
            'title' => trans('mymo_core::app.system_setting'),
            'form' => $form,
            'form_content' => $form_content,
            'settings' => $this->settingList(),
        ]);
    }
    
    public function save(Request $request)
    {
        $configs = $request->only(Config::getConfigs());
        foreach ($configs as $key => $config) {
            if ($request->has($key)) {
                Config::setConfig($key, $config);
            }
        }
    
        $form = $request->post('form');
        if (empty($form)) {
            $form = 'general';
        }
        
        return $this->success([
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.setting.form', [$form]),
        ]);
    }
    
    public function saveBlockIp(Request $request)
    {
        $this->validateRequest([
            'block_ip_status' => 'required',
            'block_ip_type' => 'required',
            'block_ip_list' => 'required',
        ], $request, [
            'block_ip_status' => trans('mymo_core::app.block_ip_status'),
            'block_ip_type' => trans('mymo_core::app.block_ip_type'),
            'block_ip_list' => trans('mymo_core::app.block_ip_list'),
        ]);
        
        $block_ip_status = $request->post('block_ip_status');
        $block_ip_type = $request->post('block_ip_type');
        $block_ip_list = $request->post('block_ip_list');
        
        Config::setConfig('block_ip_status', $block_ip_status);
        Config::setConfig('block_ip_type', $block_ip_type);
        Config::setConfig('block_ip_list', implode(',', $block_ip_list));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.setting.form', ['blockip']),
        ]);
    }
    
    protected function settingList()
    {
        return [
            'general' => trans('mymo_core::app.site_info'),
            'recaptcha' => trans('mymo_core::app.google_recaptcha'),
            //'player' => trans('mymo_core::app.player'),
            //'blockip' => trans('mymo_core::app.block_ip'),
            //'paid-members' => trans('mymo_core::app.paid_members'),
        ];
    }
}
