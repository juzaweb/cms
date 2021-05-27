<?php

namespace Mymo\Core\Http\Controllers\Backend\Design;

use Mymo\Core\Models\Config;
use Mymo\Core\Models\ThemeConfig;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;

class ThemeEditorController extends BackendController
{
    public function index() {
        $config = include resource_path('views/themes/mymo/config.php');
        
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
