<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Juzaweb\Http\Controllers\BackendController;

class ReadingController extends BackendController
{
    public function index()
    {
        $title = trans('cms::app.reading_settings');

        return view('cms::backend.reading.index', compact(
            'title'
        ));
    }

    public function save(Request $request)
    {
        $request->validate([
            'show_on_front' => 'required|string|in:posts,page',
            'home_page' => 'required_if:show_on_front,page',
            'post_page' => 'string|nullable',
        ]);

        $settings = $request->only([
            'show_on_front',
            'home_page',
            'post_page',
        ]);

        if (Arr::get($settings, 'show_on_front') == 'posts') {
            $settings['home_page'] = null;
            $settings['post_page'] = null;
        }

        foreach ($settings as $key => $value) {
            set_config($key, $value);
        }

        return $this->success([
            'message' => trans('cms::app.save_successfully'),
        ]);
    }
}
