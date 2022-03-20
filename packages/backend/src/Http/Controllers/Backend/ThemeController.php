<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Juzaweb\Backend\Http\Resources\ThemeResource;
use Juzaweb\Facades\Site;
use Juzaweb\Models\Plugin;
use Juzaweb\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Facades\Theme as FacadeTheme;
use Juzaweb\Facades\Plugin as FacadePlugin;

class ThemeController extends BackendController
{
    public function index()
    {
        $activated = jw_current_theme();
        $currentTheme = Theme::where('slug', '=', $activated)
            ->first();

        $themes = Theme::wherePublish()
            ->where('slug', '!=', $activated)
            ->paginate(10);

        return view('cms::backend.theme.index', [
            'title' => trans('cms::app.themes'),
            'themes' => $themes,
            'currentTheme' => $currentTheme,
            'activated' => $activated,
        ]);
    }

    public function getDataTheme(Request $request)
    {
        $limit = $request->get('limit', 20);
        $activated = jw_current_theme();

        $query = Theme::wherePublish()
            ->where('type', '=', 'themes')
            ->where('slug', '!=', $activated);

        $rows = $query->limit($limit)
            ->paginate();

        return ThemeResource::collection($rows);
    }

    public function activate(Request $request)
    {
        $request->validate([
            'theme' => 'required',
        ]);

        $theme = $request->post('theme');
        if (! Theme::hasTheme($theme)) {
            return $this->error([
                'message' => trans('cms::message.theme_not_found'),
            ]);
        }

        $this->putCache($theme);
        $info = FacadeTheme::getThemeInfo($theme);

        if ($require = $info->get('require')) {
            $enabeds = Plugin::whereMeta('code', array_keys($require))
                ->wherePublish()
                ->get()
                ->map(function (Plugin $item) {
                    return $item->getMeta('code');
                })
                ->values()
                ->toArray();

            $plugins = get_config('installed_plugins', []);

            foreach ($require as $plugin => $ver) {
                if (!in_array($plugin, $enabeds)) {
                    continue;
                }

                if (app('plugins')->isEnabled($plugin)) {
                    continue;
                }

                if (!in_array($plugin, array_keys($plugins))) {
                    $plugins[$plugin] = $plugin;
                }

                FacadePlugin::enable($plugin);
            }

            set_config('installed_plugins', $plugins);
        }

        return $this->success([
            'redirect' => route('admin.themes'),
        ]);
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
