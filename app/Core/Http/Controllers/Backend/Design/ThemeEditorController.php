<?php

namespace App\Http\Controllers\Backend\Design;

use App\Models\Configs;
use App\Models\ThemeConfigs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThemeEditorController extends Controller
{
    public function index() {
        $config = include resource_path('views/themes/mymo/config.php');
        
        return view('backend.design.editor.index', [
            'config' => $config,
        ]);
    }
    
    public function save(Request $request) {
        $settings = $request->post('setting');
        if ($settings) {
            $configs = Configs::getConfigs();
            foreach ($settings as $key => $setting) {
                if (in_array($key, $configs)) {
                    Configs::setConfig($key, $setting);
                }
            }
        }
    
        $model = ThemeConfigs::firstOrNew(['code' => $request->post('code')]);
        $model->content = response()->json($request->except(['setting']))->getContent();
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
}
