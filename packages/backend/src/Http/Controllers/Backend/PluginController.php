<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Http\Resources\PluginResource;
use Juzaweb\Models\Plugin;
use Juzaweb\Facades\Plugin as FacadePlugin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\ArrayPagination;

class PluginController extends BackendController
{
    public function index()
    {
        return view('cms::backend.plugin.index', [
            'title' => trans('cms::app.plugins'),
        ]);
    }

    public function install()
    {
        $this->addBreadcrumb([
            'title' => trans('cms::app.plugins'),
            'url' => action([static::class, 'index']),
        ]);

        $title = trans('cms::app.install');

        return view('cms::backend.plugin.install', compact(
            'title'
        ));
    }

    public function getDataPlugin(Request $request)
    {
        $limit = $request->get('limit', 20);
        $installed = array_keys(get_config('installed_plugins', []));

        $query = Plugin::wherePublish()
            ->where('type', '=', 'plugins')
            ->whereHas('metas', function ($q) use ($installed) {
                $q->where('meta_key', '=', 'code');
                $q->whereNotIn('meta_value', $installed);
            });

        $rows = $query->limit($limit)
            ->paginate();

        return PluginResource::collection($rows);
    }

    public function getDataTable(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $results = [];
        $plugins = get_config('installed_plugins', []);

        foreach ($plugins as $plugin) {
            /**
             * @var \Juzaweb\Abstracts\Plugin $plugin
             */
            $plugin = app('plugins')->find($plugin);

            if (empty($plugin)) {
                continue;
            }

            $item = [
                'id' => $plugin->get('name'),
                'name' => $plugin->getDisplayName(),
                'description' => $plugin->get('description'),
                'status' => $plugin->isEnabled() ? 'active' : 'inactive',
                'setting' => $plugin->getSettingUrl(),
            ];

            $results[] = $item;
        }

        $total = count($results);
        $page = (int) round(($offset + $limit) / $limit);
        $data = ArrayPagination::make($results);
        $data = $data->paginate($limit, $page);

        return response()->json([
            'total' => $total,
            'rows' => $data->items(),
        ]);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('tadcms::app.plugins'),
            'action' => trans('tadcms::app.action'),
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');

        $enabeds = Plugin::wherePublish()
            ->whereMeta('code', $ids)
            ->get()
            ->map(function (Plugin $item) {
                return $item->getMeta('code');
            })
            ->values()
            ->toArray();
        
        foreach ($ids as $plugin) {
            try {
                DB::beginTransaction();
                switch ($action) {
                    case 'delete':
                        $plugins = get_config('installed_plugins', []);
                        unset($plugins[$plugin]);

                        if (app('plugins')->isEnabled($plugin)) {
                            FacadePlugin::disable($plugin);
                        }

                        set_config('installed_plugins', $plugins);

                        break;
                    case 'activate':
                        if (!in_array($plugin, $enabeds)) {
                            break;
                        }

                        FacadePlugin::enable($plugin);
                        break;
                    case 'deactivate':
                        FacadePlugin::disable($plugin);
                        break;
                    case 'update':
                        if (!in_array($plugin, $enabeds)) {
                            break;
                        }

                        $plugins = get_config('installed_plugins', []);
                        $plugins[$plugin] = $plugin;
                        set_config('installed_plugins', $plugins);
                        break;
                }

                Cache::store('file')->pull(cache_prefix("site_actions"));

                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                return $this->error([
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return $this->success([
            'message' => trans('cms::app.successfully'),
            'redirect' => route('admin.plugin'),
        ]);
    }
}
