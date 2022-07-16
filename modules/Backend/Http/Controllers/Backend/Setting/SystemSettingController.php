<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Juzaweb\Backend\Http\Requests\Setting\SettingRequest;
use Juzaweb\CMS\Contracts\GlobalDataContract;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Models\Language;

class SystemSettingController extends BackendController
{
    protected GlobalDataContract $globalData;

    protected HookActionContract $hookAction;

    public function __construct(
        GlobalDataContract $globalData,
        HookActionContract $hookAction
    ) {
        $this->globalData = $globalData;
        $this->hookAction = $hookAction;
    }

    public function index($form = 'general'): View
    {
        $forms = $this->getForms();
        $configs = $this->hookAction->getConfigs()->where('form', $form);
        $title = $forms[$form]['name'] ?? trans('cms::app.system_setting');

        return view(
            'cms::backend.setting.system.index',
            [
                'title' => $title,
                'component' => $form,
                'forms' => $forms,
                'configs' => $configs
            ]
        );
    }

    public function save(SettingRequest $request): JsonResponse|RedirectResponse
    {
        $locales = config('locales');
        $configs = $request->only($this->hookAction->getConfigs()->keys()->toArray());

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

    protected function getForms(): \Illuminate\Support\Collection
    {
        return collect($this->globalData->get('setting_forms'))
            ->sortBy('priority');
    }
}
