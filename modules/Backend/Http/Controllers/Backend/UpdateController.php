<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/13/2021
 * Time: 11:09 AM
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\Manager\UpdateManager;
use Juzaweb\CMS\Support\JuzawebApi;
use Juzaweb\CMS\Version;

class UpdateController extends BackendController
{
    protected $api;

    public function __construct(JuzawebApi $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $title = trans('cms::app.updates');

        return view('cms::backend.update.index', compact(
            'title'
        ));
    }

    public function checkUpdate()
    {
        $updater = app(UpdateManager::class);
        $checkUpdate = $updater->checkUpdate();

        $versionAvailable = null;
        if ($checkUpdate) {
            $versionAvailable = $updater->getVersionAvailable();
        }

        return response()->json([
            'html' => view('cms::backend.update.form', compact(
                'checkUpdate',
                'versionAvailable'
            ))->render(),
        ]);
    }

    public function update(Request $request)
    {
        set_time_limit(0);
        $action = $request->post('action');
        $ids = $request->post('ids');
        if (empty($ids)) {
            $ids = [''];
        }

        $tag = 'core';
        if ($action) {
            $tag = $action;
        }

        foreach ($ids as $id) {
            DB::beginTransaction();
            try {
                $update = new UpdateManager($tag, $id);
                $update->update();
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return $this->success([
            'message' => trans('cms::app.updated_successfully'),
        ]);
    }

    public function pluginDatatable()
    {
        $plugins = app('plugins')->all();
        $data = [];
        foreach ($plugins as $plugin) {
            $data[] = [
                'code' => $plugin->get('name'),
                'current_version' => $plugin->getVersion()
            ];
        }

        $updates = $this->api->get('plugin/multi-available', [
            'plugins' => json_encode($data),
            'cms_version' => Version::getVersion(),
        ]);

        $update = collect((array) $updates)
            ->filter(function ($item) {
                return $item->status == true;
            })->map(function ($item) {
                return (array) $item;
            })
            ->toArray();
        $updateKeys = array_keys($update);

        $result = [];
        foreach ($plugins as $plugin) {
            if (!in_array($plugin->get('name'), $updateKeys)) {
                continue;
            }

            $result[] = [
                'id' => $plugin->get('name'),
                'plugin' => $plugin->getDisplayName(),
                'version' => $update[$plugin->get('name')]['version'],
            ];
        }

        return response()->json([
            'total' => count($result),
            'rows' => $result,
        ]);
    }

    public function themeDatatable()
    {
        $themes = Theme::all();
        $data = [];
        foreach ($themes as $theme) {
            $data[] = [
                'code' => $theme->get('name'),
                'current_version' => Theme::getVersion($theme->get('name'))
            ];
        }

        $updates = $this->api->get('theme/multi-available', [
            'themes' => json_encode($data),
            'cms_version' => Version::getVersion(),
        ]);

        $update = collect((array) $updates)
            ->filter(function ($item) {
                return $item->status == true;
            })
            ->map(function ($item) {
                return (array) $item;
            })
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

        return response()->json([
            'total' => count($result),
            'rows' => $result,
        ]);
    }
}
