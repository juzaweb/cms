<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Requests\Setting\SeoSettingRequest;
use Juzaweb\CMS\Http\Controllers\BackendController;

class SeoController extends BackendController
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $title = trans('cms::app.seo_setting');

        return view(
            'cms::backend.setting.seo.index',
            compact('title')
        );
    }

    public function save(SeoSettingRequest $request)
    {
        //
    }

    public function getStringRaw(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $slug = $request->input('slug');

        if (empty($slug)) {
            $slug = $title;
        }

        return response()->json(
            [
                'title' => seo_string($title, 70),
                'description' => seo_string($description, 320),
                'slug' => Str::slug(seo_string($slug, 70)),
            ]
        );
    }
}
