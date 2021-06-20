<?php

namespace Mymo\Backend\Http\Controllers\Backend\Setting;

use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Models\Config;
use Illuminate\Http\Request;

class SystemSettingController extends BackendController
{
    public function index($form = 'general')
    {
        $forms = $this->getForms();
        
        return view('mymo_core::backend.setting.system.index', [
            'title' => trans('mymo_core::app.system_setting'),
            'component' => $form,
            'forms' => $forms,
        ]);
    }
    
    public function save(Request $request)
    {
        $configs = $request->only($this->getSettings());
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

    protected function getForms()
    {
        $items = [
            'general' => [
                'name' => trans('mymo_core::app.general_setting'),
                'view' => 'mymo_core::backend.setting.system.form.general'
            ],
            'recaptcha' => [
                'name' => trans('mymo_core::app.google_recaptcha'),
                'view' => 'mymo_core::backend.setting.system.form.recaptcha'
            ]
        ];

        return apply_filters('admin.general_settings.forms', $items);
    }

    protected function getSettings()
    {
        $items = Config::getConfigs();

        return apply_filters('admin.setting_fields', $items);
    }
}
