<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Juzaweb\CMS\Abstracts\Plugin;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\JuzawebApi;
use Juzaweb\CMS\Support\Updater\CmsUpdater;
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

    public function update(CmsUpdater $updater): JsonResponse
    {
        set_time_limit(0);

        try {
            $updater->update();
        } catch (\Exception $e) {
            report($e);
            return $this->error($e->getMessage());
        }

        return $this->success(
            [
                'message' => trans('cms::app.updated_successfully'),
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
                'code' => $plugin->get('name'),
                'current_version' => $plugin->getVersion()
            ];
        }

        $updates = $this->api->post(
            'releases/plugins/multi-version-available',
            [
                'plugins' => $data,
                'cms_version' => Version::getVersion(),
            ]
        );

        $update = collect((array) $updates)
            ->filter(
                function ($item) {
                    return $item->status == true;
                }
            )->map(
                function ($item) {
                    return (array) $item;
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
                'version' => $update[$plugin->get('name')]['version'],
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
        $themes = Theme::all();
        $data = [];
        foreach ($themes as $theme) {
            $data[] = [
                'code' => $theme->get('name'),
                'current_version' => Theme::getVersion($theme->get('name'))
            ];
        }

        $updates = $this->api->get(
            'theme/multi-available',
            [
                'themes' => json_encode($data),
                'cms_version' => Version::getVersion(),
            ]
        );

        $update = collect((array) $updates)
            ->filter(
                function ($item) {
                    return $item->status == true;
                }
            )
            ->map(
                function ($item) {
                    return (array) $item;
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
                'version' => $update[$theme->get('name')]['version'],
            ];
        }

        return response()->json(
            [
                'total' => count($result),
                'rows' => $result,
            ]
        );
    }
}
