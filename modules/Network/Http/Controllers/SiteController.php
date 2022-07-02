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

use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\Network\Http\Datatables\SiteDatatable;
use Juzaweb\Network\Models\Site;

class SiteController extends Controller
{
    use ResourceController;

    protected string $viewPrefix = 'network::site';

    protected function getDataTable(...$params)
    {
        return new SiteDatatable();
    }

    protected function validator(array $attributes, ...$params)
    {
        return [
            'domain' => 'required|max:50|min:4|regex:/(^[a-z0-9\-]+$)+/|unique:sites,domain,' . $attributes['id'],
        ];
    }

    protected function getModel(...$params): string
    {
        return Site::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('cms::app.network.sites');
    }
}
