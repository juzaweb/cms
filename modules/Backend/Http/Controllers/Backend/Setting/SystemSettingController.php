<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Juzaweb\CMS\Facades\GlobalData;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Models\Config;
use Juzaweb\CMS\Models\Language;

class SystemSettingController extends BackendController
{
    public function index($form = 'general')
    {
        $forms = $this->getForms();

        return view(
            'cms::backend.setting.system.index',
            [
                'title' => trans('cms::app.system_setting'),
                'component' => $form,
                'forms' => $forms,
            ]
        );
    }

    public function save(Request $request)
    {
        $locales = config('locales');
        $configs = $request->only(Config::configs());

        foreach ($configs as $key => $config) {
            if ($request->has($key)) {
                set_config($key, $config);

                if ($key == 'language') {
                    if (!Language::existsCode($config)) {
                        Language::create(
                            [
                                'code' => $config,
                                'name' => $locales[$config]['name']
                            ]
                        );
                    }

                    Language::setDefault($config);
                }
            }
        }

        return $this->success(
            [
                'message' => trans('cms::app.saved_successfully'),
            ]
        );
    }

    protected function getForms()
    {
        return collect(GlobalData::get('setting_forms'))->sortBy('priority');
    }
}
