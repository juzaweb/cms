<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Juzaweb\CMS\Facades\GlobalData;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Models\Config;
use Juzaweb\CMS\Models\Language;

class SystemSettingController extends BackendController
{
    public function index($form = 'general'): \Illuminate\Contracts\View\View
    {
        $forms = $this->getForms();
        $configs = $this->getConfigs()->where('form', $form);

        return view(
            'cms::backend.setting.system.index',
            [
                'title' => trans('cms::app.system_setting'),
                'component' => $form,
                'forms' => $forms,
                'configs' => $configs
            ]
        );
    }

    public function save(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $locales = config('locales');
        $configs = $request->only($this->getConfigs()->keys());

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

    protected function getConfigs(): \Illuminate\Support\Collection
    {
        $configs = config('juzaweb.config');
        $configs = array_merge(GlobalData::get('configs'), $configs);
        return collect($configs)->mapWithKeys(
            function ($item, $key) {
                if (is_int($key) && is_string($item)) {
                    return [
                        $item => [
                            "type" => "text",
                            "label" => trans("cms::config.{$item}")
                        ]
                    ];
                }

                return [
                    $key => $item
                ];
            }
        );
    }

    protected function getForms(): \Illuminate\Support\Collection
    {
        return collect(GlobalData::get('setting_forms'))->sortBy('priority');
    }
}
