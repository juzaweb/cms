<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package juzaweb/cms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://juzaweb.com/cms
 */

namespace Juzaweb\CMS\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
