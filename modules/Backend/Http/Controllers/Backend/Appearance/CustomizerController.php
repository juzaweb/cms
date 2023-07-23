<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Appearance;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Juzaweb\CMS\Facades\ThemeConfig;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\Theme\Customize;
use Juzaweb\CMS\Support\Theme\CustomizeControl;

class CustomizerController extends BackendController
{
    protected string $template = 'inertia';

    public function index(): View|Response
    {
        Inertia::setRootView('cms::layouts.customizer');

        $currentTheme = jw_current_theme();

        $panels = $this->getDataCustomize($currentTheme)->values();

        return $this->view(
            'cms::backend.customizer.index',
            [
                'panels' => $panels,
            ]
        );
    }

    public function save(Request $request): JsonResponse|RedirectResponse
    {
        $settings = $request->post('setting', []);
        if ($settings) {
            foreach ($settings as $key => $setting) {
                set_config($key, $setting);
            }
        }

        $data = $request->post('theme', []);

        foreach ($data as $key => $value) {
            ThemeConfig::setConfig($key, $value);
        }

        return $this->success(
            [
                'message' => trans('cms::app.saved_successfully'),
            ]
        );
    }

    protected function getDataCustomize($currentTheme): Collection
    {
        $customize = new Customize();
        $customize->addSection(
            'site_identity',
            [
                'title' => __("cms::app.site_identity"),
                'priority' => 1,
            ]
        );

        $customize->addControl(
            new CustomizeControl(
                $customize,
                'site_identity',
                [
                    'label' => __('cms::app.site_identity'),
                    'section' => 'site_identity',
                    'settings' => 'site_identity',
                    'type' => 'site_identity',
                ]
            )
        );

        $themePath = base_path("themes/{$currentTheme}/config/customize.php");
        if (file_exists($themePath)) {
            include $themePath;
        }

        /**
         * @var Customize $customize
         */
        $customize = apply_filters('theme_editor.get_customize', $customize);
        $panels = $customize->getPanel()->sortBy('priority');
        foreach ($panels as $key => $panel) {
            $sections = $customize->getSection()->where('panel', $key);
            if ($sections->isEmpty()) {
                continue;
            }

            $childs = $panel->get('childs', new Collection([]));
            foreach ($sections as $secKey => $section) {
                $controls = $customize->getControl()->where('section', $secKey);
                $section->put('controls', $controls);

                $childs->put($secKey, $section);
            }

            $panel->put('childs', $childs);
        }

        $sections = $customize->getSection()->whereNull('panel');
        foreach ($sections as $secKey => $section) {
            $controls = $customize->getControl()->where('section', $secKey);
            $section->put('controls', $controls);
            $panels->put($secKey, $section);
        }

        return $panels;
    }
}
