<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Subscription\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\BackendController;

class SettingController extends BackendController
{
    public function index()
    {
        $title = trans('subr::content.subscription');
        $data = get_config('subscription');

        return view('subr::backend.setting.index', compact(
            'title',
            'data'
        ));
    }

    public function save(Request $request)
    {
        $subscription = $request->only('subscription');
        $configs = $subscription['subscription'];

        set_config('subscription', $configs);

        return $this->success([
            'message' => trans('cms::app.save_successfully')
        ]);
    }
}
