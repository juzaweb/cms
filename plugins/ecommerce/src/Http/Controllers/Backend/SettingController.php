<?php

namespace Juzaweb\Ecommerce\Http\Controllers\Backend;

use Juzaweb\Backend\Http\Controllers\Backend\PageController;

class SettingController extends PageController
{
    public function index()
    {
        $title = trans('ecom::content.setting');

        return view(
            'ecom::backend.setting.index',
            compact(
                'title'
            )
        );
    }
}
