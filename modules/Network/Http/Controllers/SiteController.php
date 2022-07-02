<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Http\Controllers;

use Juzaweb\CMS\Http\Controllers\BackendController;

class SiteController extends BackendController
{
    public function index()
    {
        $title = trans('cms::app.network.sites');

        return view('network::site.index', compact('title'));
    }
}
