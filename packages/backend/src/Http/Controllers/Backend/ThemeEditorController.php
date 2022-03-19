<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Juzaweb\Facades\ThemeConfig;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\Theme\Customize;
use Juzaweb\Support\Theme\CustomizeControl;

class ThemeEditorController extends BackendController
{
    public function index()
    {
        $currentTheme = jw_current_theme();
        $panels = $this->getDataCustomize($currentTheme);

        return view('cms::backend.editor.index', [
            'panels' => $panels,
        ]);
    }

    public function save(Request $request)
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

        return $this->success([
            'message' => trans('cms::app.saved_successfully'),
        ]);
    }

    protected function getDataCustomize($currentTheme)
    {
        $customize = new Customize();
        $customize->addSection('site_identity', [
            'title' => __("cms::app.site_identity"),
            'priority' => 1,
        ]);

        $customize->addControl(new CustomizeControl($customize, 'site_identity', [
            'label' => __('cms::app.site_identity'),
            'section' => 'site_identity',
            'settings' => 'site_identity',
            'type' => 'site_identity',
        ]));

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
