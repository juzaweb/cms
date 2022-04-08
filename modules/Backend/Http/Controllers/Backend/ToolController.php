<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Juzaweb\CMS\Http\Controllers\BackendController;

class ToolController extends BackendController
{
    public function index()
    {
        //

        return view(
            'juto::index',
            [
                'title' => 'Title Page',
            ]
        );
    }
}
