<?php

namespace Juzaweb\Example\Http\Controllers;

use Juzaweb\CMS\Http\Controllers\BackendController;

class ExampleController extends BackendController
{
    public function index()
    {
        //

        return view(
            'juex::index',
            [
                'title' => 'Title Page',
            ]
        );
    }
}
