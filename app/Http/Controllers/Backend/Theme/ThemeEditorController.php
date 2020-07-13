<?php

namespace App\Http\Controllers\Backend\Theme;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThemeEditorController extends Controller
{
    public function index() {
        $config = include resource_path('views/frontend/config.php');
        
        return view('backend.theme.editor.index', [
            'config' => $config,
        ]);
    }
}
