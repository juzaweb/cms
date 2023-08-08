<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\CMS\Abstracts\UpdateManager;
use Juzaweb\CMS\Contracts\BackendMessageContract;
use Juzaweb\CMS\Contracts\JuzawebApiContract;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Support\Updater\CmsUpdater;
use Juzaweb\CMS\Support\Updater\PluginUpdater;
use Juzaweb\CMS\Support\Updater\ThemeUpdater;
use Juzaweb\CMS\Version;

class UpdateController extends BackendController
{
    protected JuzawebApiContract $api;

    public function __construct(JuzawebApiContract $api)
    {
        $this->api = $api;
    }

    public function index(): View
    {
        if (!config('juzaweb.plugin.enable_upload')) {
            abort(403);
        }

        $title = trans('cms::app.updates');

        return view(
            'cms::backend.update.index',
            compact(
                'title'
            )
        );
    }

    public function checkUpdate(CmsUpdater $updater): JsonResponse
    {
        $currentVersion = $updater->getCurrentVersion();
        $versionAvailable = $updater->getVersionAvailable();

        $checkUpdate = version_compare(
            $versionAvailable,
            $currentVersion,
            '>'
        );

        return response()->json(
            [
                'html' => view(
                    'cms::backend.update.components.cms_check',
                    compact(
                        'checkUpdate',
                        'versionAvailable'
                    )
                )->render(),
            ]
        );
    }

    public function update(Request $request, string $type): View
    {
        if (!config('juzaweb.plugin.enable_upload')) {
            abort(403);
        }

        $this->addBreadcrumb(
            [
                'url' => route('admin.update'),
                'title' => trans('cms::app.updates')
            ]
        );

        $title = trans('cms::app.updating');

        $action = $request->input('action', 'update');
        $referren = $request->input('referren');
        $updater = $this->getUpdater($type);
        $themes = $request->input('themes', []);
        $plugins = $request->input('plugins', []);

        return view(
            'cms::backend.update.form',
            compact(
                'title',
                'updater',
                'type',
                'themes',
                'plugins',
                'action',
                'referren'
            )
        );
    }

    public function updateStep(Request $request, string $type, int $step): JsonResponse
    {
        set_time_limit(0);

        if (!config('juzaweb.plugin.enable_upload')) {
            abort(403);
        }

        $updater = $this->getUpdater($type);

        if ($type == 'theme') {
            $theme = $request->input('theme');
            if (empty($theme)) {
                throw new \Exception('Theme is required.');
            }

            $updater = $updater->find($theme);
        }

        if ($type == 'plugin') {
            $plugin = $request->input('plugin');
            if (empty($plugin)) {
                throw new \Exception('Plugin is required.');
            }

            $updater = $updater->find($plugin);
        }

        if ($step <= 0 || $step > $updater->getMaxStep()) {
            abort(404);
        }

        try {
            $updater->updateByStep($step);
        } catch (\Exception $e) {
            report($e);
            return response()->json(
                [
                    'status' => false,
                    'data' => [
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }

        $next = $step < $updater->getMaxStep();

        return response()->json(
            [
                'status' => true,
                'data' => [
                    'message' => $next ? 'Done' : trans('cms::app.updated_successfully'),
                    'next_url' => $next ? route(
                        'admin.update.step',
                        [
                            $type,
                            $step + 1
                        ]
                    ) : null,
                ]
            ]
        );
    }

    public function pluginDatatable(): JsonResponse
    {
        $plugins = app('plugins')->all();
        $data = [];
        foreach ($plugins as $plugin) {
            /**
             * @var Plugin $plugin
             */

            $data[] = [
                'name' => $plugin->get('name'),
                'current_version' => $plugin->getVersion(),
            ];
        }

        $response = $this->api->post(
            'plugins/versions-available',
            [
                'plugins' => $data,
                'cms_version' => Version::getVersion(),
            ]
        );

        $updates = $response->data ?? [];

        $update = collect((array)$updates)
            ->filter(
                function ($item) {
                    return $item->update == true;
                }
            )->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();
        $updateKeys = array_keys($update);

        $result = [];
        foreach ($plugins as $plugin) {
            /**
             * @var Plugin $plugin
             */
            if (!in_array($plugin->get('name'), $updateKeys)) {
                continue;
            }

            $result[] = [
                'id' => $plugin->get('name'),
                'plugin' => $plugin->getDisplayName(),
                'current_version' => $plugin->getVersion(),
                'new_version' => $update[$plugin->get('name')]['version'],
            ];
        }

        return response()->json(
            [
                'total' => count($result),
                'rows' => $result,
            ]
        );
    }

    public function themeDatatable(): JsonResponse
    {
        $themes = ThemeLoader::all();
        $data = [];
        foreach ($themes as $theme) {
            $data[] = [
                'name' => $theme->get('name'),
                'current_version' => ThemeLoader::getVersion($theme->get('name')),
            ];
        }

        $response = $this->api->post(
            'themes/versions-available',
            [
                'themes' => $data,
                'cms_version' => Version::getVersion(),
            ]
        );

        $updates = $response->data ?? [];

        $update = collect((array)$updates)
            ->filter(
                function ($item) {
                    return $item->update == true;
                }
            )
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();

        $updateKeys = array_keys($update);

        $result = [];
        foreach ($themes as $theme) {
            if (!in_array($theme->get('name'), $updateKeys)) {
                continue;
            }

            $result[] = [
                'id' => $theme->get('name'),
                'theme' => $theme->get('title'),
                'current_version' => $theme->get('version'),
                'new_version' => $update[$theme->get('name')]['version'],
            ];
        }

        return response()->json(
            [
                'total' => count($result),
                'rows' => $result,
            ]
        );
    }

    public function updateSuccess(Request $request): JsonResponse
    {
        $type = $request->input('type');
        if ($type == 'cms') {
            $key = cache_prefix('check_cms_update');
            Cache::store('file')->pull($key);
        }

        event(new DumpAutoloadPlugin());

        app(BackendMessageContract::class)->deleteGroup('require_plugins');

        return response()->json(
            [
                'status' => true,
                'data' => [
                    'message' => 'Done'
                ]
            ]
        );
    }

    protected function getUpdater(string $type): UpdateManager|PluginUpdater|ThemeUpdater
    {
        switch ($type) {
            case 'cms':
                return app(CmsUpdater::class);
            case 'theme':
                return app(ThemeUpdater::class);
            case 'plugin':
                return app(PluginUpdater::class);
        }

        throw new \Exception('Updater Not found.');
    }
}
