<?php

namespace Juzaweb\Payment\Http\Controllers;

use Juzaweb\CMS\Http\Controllers\BackendController;

class PaymentController extends BackendController
{
    public function index()
    {
        //

        return view('jupa::index', [
            'title' => 'Title Page',
        ]);
    }
}
