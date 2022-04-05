<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\ArrayPagination;

class PluginController extends BackendController
{
    public function index()
    {
        return view(
            'cms::backend.plugin.index',
            [
                'title' => trans('cms::app.plugins'),
            ]
        );
    }

    public function getDataTable(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $results = [];
        $plugins = Plugin::all();
        
        foreach ($plugins as $name => $plugin) {
            /**
             * @var \Juzaweb\Abstracts\Plugin $plugin
             */

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

        return response()->json(
            [
                'total' => $total,
                'rows' => $data->values(),
            ]
        );
    }

    public function bulkActions(Request $request)
    {
        $request->validate(
            [
                'ids' => 'required',
                'action' => 'required',
            ],
            [],
            [
                'ids' => trans('tadcms::app.plugins'),
                'action' => trans('tadcms::app.action'),
            ]
        );

        $action = $request->post('action');
        $ids = $request->post('ids');
        
        foreach ($ids as $plugin) {
            try {
                //DB::beginTransaction();
                switch ($action) {
                    /*case 'delete':
                        $plugins = get_config('installed_plugins', []);
                        unset($plugins[$plugin]);

                        if (app('plugins')->isEnabled($plugin)) {
                            Plugin::disable($plugin);
                        }
                        break;*/
                    case 'activate':
                        Plugin::enable($plugin);
                        break;
                    case 'deactivate':
                        Plugin::disable($plugin);
                        break;
                }

                //DB::commit();
            } catch (\Throwable $e) {
                //DB::rollBack();
                return $this->error(
                    [
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }

        return $this->success(
            [
                'message' => trans('cms::app.successfully'),
                'redirect' => route('admin.plugin'),
            ]
        );
    }
}
