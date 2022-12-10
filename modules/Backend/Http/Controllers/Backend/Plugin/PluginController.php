<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Plugin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Juzaweb\Backend\Events\AfterPluginBulkAction;
use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\Backend\Http\Requests\Plugin\BulkActionRequest;
use Juzaweb\CMS\Contracts\JuzawebApiContract;
use Juzaweb\CMS\Facades\CacheGroup;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\ArrayPagination;
use Juzaweb\CMS\Support\Plugin as SupportPlugin;
use Juzaweb\CMS\Version;

class PluginController extends BackendController
{
    protected JuzawebApiContract $api;

    public function __construct(JuzawebApiContract $api)
    {
        $this->api = $api;
    }

    public function index(Request $request): View
    {
        global $jw_user;
        if (!$jw_user->can('plugins.index')) {
            abort(403);
        }

        return view(
            'cms::backend.plugin.index',
            [
                'title' => trans('cms::app.plugins'),
            ]
        );
    }

    public function getDataTable(Request $request): JsonResponse
    {
        global $jw_user;
        if (!$jw_user->can('plugins.index')) {
            abort(403);
        }

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
             * @var SupportPlugin $plugin
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

    public function bulkActions(BulkActionRequest $request): JsonResponse
    {
        global $jw_user;
        if (!$jw_user->can('plugins.edit')) {
            abort(403);
        }

        $action = $request->post('action');
        $ids = $request->post('ids');

        if (in_array($action, ['update', 'install'])) {
            $query = [
                'plugins' => $ids,
                'action' => $action,
                'referren' => URL::previous(),
            ];
            $query = http_build_query($query);

            return $this->success(
                [
                    'window_redirect' => route('admin.update.process', ['plugin']).'?'.$query,
                ]
            );
        }

        if ($ids) {
            event(new DumpAutoloadPlugin());
        }

        foreach ($ids as $plugin) {
            try {
                switch ($action) {
                    case 'delete':
                        if (!config('juzaweb.plugin.enable_upload')) {
                            throw new \Exception('Access deny.');
                        }
                        /**
                         * @var SupportPlugin $module
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

        event(new AfterPluginBulkAction($action, $ids));

        return $this->success(
            [
                'message' => trans('cms::app.successfully'),
                'window_redirect' => route('admin.plugin'),
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
