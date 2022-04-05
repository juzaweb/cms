<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Juzaweb\Backend\Http\Resources\ThemeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Support\ArrayPagination;

class ThemeController extends BackendController
{
    public function index()
    {
        $activated = jw_current_theme();
        $currentTheme = Theme::getThemeInfo($activated);
        
        return view(
            'cms::backend.theme.index',
            [
                'title' => trans('cms::app.themes'),
                'currentTheme' => $currentTheme,
                'activated' => $activated,
            ]
        );
    }

    public function getDataTheme(Request $request)
    {
        $limit = $request->get('limit', 20);
        $activated = jw_current_theme();
        
        $paginate = ArrayPagination::make(Theme::all(true));
        $paginate->where('name', '!=', $activated);
        
        $rows = $paginate->paginate($limit);
        $items = new Collection();
        foreach ($rows->items() as $key => $row) {
            $items->push((object) $row);
        }
        
        $rows->setCollection($items);
        
        return ThemeResource::collection($rows);
    }

    public function activate(Request $request)
    {
        $request->validate(
            [
                'theme' => 'required',
            ]
        );

        $theme = $request->post('theme');
        if (! Theme::has($theme)) {
            return $this->error(
                [
                    'message' => trans('cms::message.theme_not_found'),
                ]
            );
        }

        $this->putCache($theme);
        $info = Theme::getThemeInfo($theme);

        if ($require = $info->get('require')) {
            $plugins = Plugin::all();
            $str = [];
            foreach ($require as $plugin => $ver) {
                if (app('plugins')->isEnabled($plugin)) {
                    continue;
                }

                if (!in_array($plugin, array_keys($plugins))) {
                    $plugins[$plugin] = $plugin;
                }
                
                $str[] = "<strong>{$plugin}</strong>";
            }
    
            add_backend_message(
                'require_plugins',
                [
                    trans('cms::app.theme_require_plugins') .' '
                    . implode(', ', $str) . '
                        . <a href="'. route('admin.themes.require-plugins') .'"><strong>'
                    . trans('cms::app.activate_plugins')
                    .'</strong></a>',
                ],
                'warning'
            );
        }

        return $this->success(
            [
                'redirect' => route('admin.themes'),
            ]
        );
    }

    protected function putCache($theme)
    {
        DB::beginTransaction();
        try {
            Cache::pull(cache_prefix('jw_theme_configs'));

            $themeStatus = [
                'name' => $theme,
                'namespace' => 'Theme\\',
                'path' => config('juzaweb.theme.path') .'/'.$theme,
            ];

            set_config('theme_statuses', $themeStatus);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
