<?php

namespace App\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemSettingController extends Controller
{
    public function index() {
        return view('backend.setting.system.index', [
            'title' => trans('app.system_setting')
        ]);
    }
    
    public function save(Request $request) {
    
    }
}
