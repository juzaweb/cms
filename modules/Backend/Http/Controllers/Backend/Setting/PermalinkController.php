<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;

class PermalinkController extends BackendController
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $title = trans('cms::app.permalinks');
        $permalinks = HookAction::getPermalinks();

        return view(
            'cms::backend.permalink.index',
            compact(
                'title',
                'permalinks'
            )
        );
    }

    public function save(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $request->validate(
            [
                'permalink' => 'required|array',
                'permalink.*.base' => 'required|string|min:3|max:15',
            ]
        );

        $permalinks = HookAction::getPermalinks();
        $data = $request->post('permalink');
        $result = [];

        foreach ($permalinks as $key => $permalink) {
            $result[$key] = [
                'base' => $data[$key]['base']
            ];
        }

        set_config('permalinks', $result);

        do_action(Action::PERMALINKS_SAVED_ACTION, $permalinks);

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
                'redirect' => route('admin.permalink'),
            ]
        );
    }
}
