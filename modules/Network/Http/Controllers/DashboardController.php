<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Http\Controllers;

use Illuminate\Contracts\View\View;
use Juzaweb\CMS\Http\Controllers\BackendController;

class DashboardController extends BackendController
{
    public function index(): View
    {
        $title = trans('cms::app.dashboard');

        return view('network::dashboard', compact('title'));
    }
}
