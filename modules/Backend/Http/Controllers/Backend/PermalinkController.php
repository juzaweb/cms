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
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;

class PermalinkController extends BackendController
{
    public function index()
    {
        $title = trans('cms::app.permalinks');
        $permalinks = HookAction::getPermalinks();

        return view('cms::backend.permalink.index', compact(
            'title',
            'permalinks'
        ));
    }

    public function save(Request $request)
    {
        $request->validate([
            'permalink' => 'required|array',
            'permalink.*.base' => 'required|string|min:3|max:15',
        ]);

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

        return $this->success([
            'message' => trans('cms::app.save_successfully'),
            'redirect' => route('admin.permalink'),
        ]);
    }
}
