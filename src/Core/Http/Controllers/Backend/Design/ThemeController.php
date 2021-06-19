<?php

namespace Mymo\Core\Http\Controllers\Backend\Design;

use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Traits\ArrayPagination;
use Mymo\Theme\Facades\Theme;

class ThemeController extends BackendController
{
    use ArrayPagination;

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $activated = get_config('activated_theme', 'default');

        $themes = Theme::all();
        $currentTheme = $themes[$activated] ?? null;
        unset($themes[$activated]);
        $themes = $this->arrayPaginate($themes, 10, $page);

        return view('mymo_core::backend.design.themes.index', [
            'title' => trans('mymo_core::app.themes'),
            'themes' => $themes,
            'currentTheme' => $currentTheme,
            'activated' => $activated
        ]);
    }
    
    public function activate(Request $request)
    {
        $request->validate([
            'theme' => 'required'
        ]);

        $theme = $request->post('theme');
        if (!Theme::has($theme)) {
            return $this->error([
                'message' => trans('mymo_core::message.theme_not_found')
            ]);
        }

        set_config('activated_theme', $theme);
        return $this->success([
            'redirect' => route('admin.design.themes'),
        ]);
    }

    public function delete(Request $request)
    {

    }
}
