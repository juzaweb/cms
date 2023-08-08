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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Juzaweb\Backend\Http\Requests\Setting\ReadingSettingRequest;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ReadingController extends BackendController
{
    public function index()
    {
        $title = trans('cms::app.reading_settings');

        return view(
            'cms::backend.reading.index',
            compact(
                'title'
            )
        );
    }

    public function save(ReadingSettingRequest $request): JsonResponse|RedirectResponse
    {
        $settings = $request->only(
            [
                'show_on_front',
                'home_page',
                'post_page',
                'posts_per_page',
                'posts_per_rss',
            ]
        );

        if (Arr::get($settings, 'show_on_front') == 'posts') {
            $settings['home_page'] = null;
            $settings['post_page'] = null;
        }

        foreach ($settings as $key => $value) {
            set_config($key, $value);
        }

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
            ]
        );
    }
}
