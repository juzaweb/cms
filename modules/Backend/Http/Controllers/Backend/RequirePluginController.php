<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\BackendController;

class RequirePluginController extends BackendController
{
    public function index()
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.themes'),
                'url' => route('admin.themes'),
            ]
        );

        $title = trans('cms::app.require_plugins');

        return view(
            'cms::backend.theme.require',
            compact(
                'title'
            )
        );
    }

    public function getData()
    {
        $themeInfo = ThemeLoader::getThemeInfo(jw_current_theme());
        $require = $themeInfo->get('require', []);
        $result = [];

        foreach ($require as $plugin => $ver) {
            $info = app('plugins')->find($plugin);
            if ($info) {
                if ($info->isEnabled()) {
                    continue;
                }
            }

            $result[] = [
                'id' => $plugin,
                'key' => $plugin,
                'version' => $ver,
                'status' => $info ? 'installed' : 'not_installed',
            ];
        }

        return response()->json(
            [
                'total' => count($result),
                'rows' => $result,
            ]
        );
    }

    public function bulkActions(Request $request)
    {
        $this->validate(
            $request,
            [
                'ids' => 'array|required',
                'action' => 'required',
            ]
        );

        $ids = $request->post('ids');
        $action = $request->post('action');

        if ($action == 'install') {
            $query = ['plugins' => $ids];
            $query = http_build_query($query);

            return $this->success(
                [
                    'window_redirect' => route('admin.update.process', ['plugin']).'?'.$query,
                ]
            );
        }

        $errors = [];

        switch ($action) {
            case 'activate':
                foreach ($ids as $id) {
                    $info = app('plugins')->find($id);
                    if (empty($info)) {
                        $errors[] = trans(
                            'cms::app.plugin_name_not_found',
                            [
                                'name' => $id
                            ]
                        );
                        continue;
                    }

                    $info->enable();
                }
                break;
        }

        remove_backend_message('require_plugins');

        if ($errors) {
            return $this->error(
                [
                    'message' => $errors[0],
                ]
            );
        }

        return $this->success(
            [
                'message' => trans('cms::app.successfully'),
            ]
        );
    }
}
