<?php

namespace Mymo\Backend\Http\Controllers\Backend\Design;

use Mymo\Core\Models\Config;
use Mymo\Core\Models\ThemeConfig;
use Illuminate\Http\Request;
use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Theme\Facades\Theme;

class ThemeEditorController extends BackendController
{
    public function index() {
        Theme::set('mymo');
        $config = include base_path('themes/mymo/config.php');

        return view('mymo_core::backend.design.editor.index', [
            'config' => $config,
        ]);
    }
    
    public function save(Request $request) {
        $settings = $request->post('setting');
        if ($settings) {
            $configs = Config::getConfigs();
            foreach ($settings as $key => $setting) {
                if (in_array($key, $configs)) {
                    Config::setConfig($key, $setting);
                }
            }
        }
    
        $model = ThemeConfig::firstOrNew(['code' => $request->post('code')]);
        $model->content = response()->json($request->except(['setting']))->getContent();
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
        ]);
    }
}
