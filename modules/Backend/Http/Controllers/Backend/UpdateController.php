<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzaweb/juzacms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\JuzawebApi;
use Juzaweb\CMS\Support\Manager\UpdateManager;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Support\Updater\CmsUpdater;
use Juzaweb\CMS\Support\Updater\PluginUpdater;
use Juzaweb\CMS\Support\Updater\ThemeUpdater;
use Juzaweb\CMS\Version;

class UpdateController extends BackendController
{
    protected JuzawebApi $api;

    public function __construct(JuzawebApi $api)
    {
        $this->api = $api;
    }

    public function index(): View
    {
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
                    'cms::backend.update.form',
                    compact(
                        'checkUpdate',
                        'versionAvailable'
                    )
                )->render(),
            ]
        );
    }

    public function update(string $type, int $step): JsonResponse
    {
        set_time_limit(0);

        if (!config('juzaweb.plugin.enable_upload')) {
            abort(403);
        }

        $updater = $this->getUpdater($type);

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

        return response()->json(
            [
                'status' => true,
                'data' => [
                    'message' => 'Done',
                    'next_url' => $step < $updater->getMaxStep() ? route(
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

    protected function getUpdater(string $type): UpdateManager
    {
        switch ($type) {
            case 'cms':
                return app(CmsUpdater::class);
            case 'theme':
                return app(PluginUpdater::class);
            case 'plugin':
                return app(ThemeUpdater::class);
        }

        throw new \Exception('Updater Not found.');
    }
}
