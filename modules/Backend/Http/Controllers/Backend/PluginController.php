<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Http\Requests\Plugin\BulkActionRequest;
use Juzaweb\CMS\Facades\CacheGroup;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\ArrayPagination;
use Juzaweb\CMS\Support\JuzawebApi;
use Juzaweb\CMS\Support\Updater\PluginUpdater;
use Juzaweb\CMS\Version;

class PluginController extends BackendController
{
    protected JuzawebApi $api;

    public function __construct(JuzawebApi $api)
    {
        $this->api = $api;
    }

    public function index(): View
    {
        return view(
            'cms::backend.plugin.index',
            [
                'title' => trans('cms::app.plugins'),
            ]
        );
    }

    public function install(): View
    {
        if (!config('juzaweb.plugin.enable_upload')) {
            abort(403, 'Access deny.');
        }

        $title = trans('cms::app.install');

        return view(
            'cms::backend.plugin.install',
            compact('title')
        );
    }

    public function getDataTable(Request $request): JsonResponse
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $plugins = Plugin::all();
        $total = count($plugins);
        $page = (int) round(($offset + $limit) / $limit);
        $data = ArrayPagination::make($plugins);
        $data = $data->paginate($limit, $page);
        $updates = $this->getDataUpdates($data->getCollection());

        $results = [];
        foreach ($data as $plugin) {
            /**
             * @var Plugin $plugin
             */
            $results[] = [
                'id' => $plugin->get('name'),
                'name' => $plugin->getDisplayName(),
                'description' => $plugin->get('description'),
                'status' => $plugin->isEnabled() ? 'active' : 'inactive',
                'setting' => $plugin->getSettingUrl(),
                'version' => $plugin->getVersion(),
                'update' => $updates->{$plugin->get('name')}->update ?? false,
            ];
        }

        return response()->json(
            [
                'total' => $total,
                'rows' => $results,
            ]
        );
    }

    public function getDataPlugin(Request $request, JuzawebApi $api): object|array
    {
        $limit = $request->get('limit', 20);
        $page = $request->get('page', 1);
        $except = array_keys(Plugin::all());

        return $api->get(
            'plugins',
            [
                'limit' => $limit,
                'page' => $page,
                'except' => $except
            ]
        );
    }

    public function bulkActions(BulkActionRequest $request, PluginUpdater $updater): JsonResponse
    {
        $action = $request->post('action');
        $ids = $request->post('ids');

        if ($action == 'update') {
            $query = ['plugins' => $ids];
            $query = http_build_query($query);

            return $this->success(
                [
                    'window_redirect' => route('admin.update.process', ['plugin']).'?'.$query,
                ]
            );
        }

        foreach ($ids as $plugin) {
            try {
                switch ($action) {
                    case 'delete':
                        if (!config('juzaweb.plugin.enable_upload')) {
                            throw new \Exception('Access deny.');
                        }
                        /**
                         * @var \Juzaweb\CMS\Support\Plugin $module
                         */
                        $module = app('plugins')->find($plugin);
                        if ($module->isEnabled()) {
                            $module->disable();
                        }

                        $module->delete();
                        break;
                    case 'activate':
                        Plugin::enable($plugin);
                        break;
                    case 'deactivate':
                        Plugin::disable($plugin);
                        break;
                }
            } catch (\Throwable $e) {
                report($e);
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

    protected function getDataUpdates(Collection $plugins): ?object
    {
        if (!config('juzaweb.plugin.enable_upload')) {
            return (object) [];
        }

        $key = sha1($plugins->toJson());
        CacheGroup::add('plugin_update_keys', $key);

        return Cache::remember(
            $key,
            3600,
            function () use ($plugins) {
                try {
                    $response = $this->api->post(
                        'plugins/versions-available',
                        [
                            'plugins' => $plugins->map(
                                function ($item) {
                                    return [
                                        'name' => $item->get('name'),
                                        'current_version' => $item->getVersion(),
                                    ];
                                }
                            )->values()->toArray(),
                            'cms_version' => Version::getVersion(),
                        ]
                    );

                    if (empty($response->data)) {
                        return (object) [];
                    }

                    return $response->data;
                } catch (\Exception $e) {
                    return (object) [];
                }
            }
        );
    }
}
