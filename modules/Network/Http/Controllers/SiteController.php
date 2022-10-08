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

use Illuminate\Validation\Rule;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\Network\Contracts\SiteManagerContract;
use Juzaweb\Network\Http\Datatables\SiteDatatable;
use Juzaweb\Network\Models\Site;

class SiteController extends Controller
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected SiteManagerContract $siteManager;

    protected string $viewPrefix = 'network::site';

    public function __construct(SiteManagerContract $siteManager)
    {
        $this->siteManager = $siteManager;
    }

    protected function getDataTable(...$params): DataTable
    {
        return new SiteDatatable();
    }

    protected function validator(array $attributes, ...$params): array
    {
        return [
            'domain' => [
                'bail',
                'required',
                'max:50',
                'min:4',
                "regex:/(^[a-z0-9\-]+)/",
                Rule::modelUnique(
                    Site::class,
                    'domain',
                    function ($q) {
                        $q->where('id', '!=', request()->route()->parameter('id'));
                    }
                )
            ],
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

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model, ...$params);
        $data['statuses'] = Site::getAllStatus();
        return $data;
    }

    protected function storeSuccess($request, $model, ...$params): void
    {
        $this->siteManager->getCreater()->setupSite($model);
    }
}
