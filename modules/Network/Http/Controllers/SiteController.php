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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\Network\Contracts\SiteManagerContract;
use Juzaweb\Network\Http\Datatables\SiteDatatable;
use Juzaweb\Network\Http\Requests\AddMappingDomainRequest;
use Juzaweb\Network\Models\Site;

class SiteController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected SiteManagerContract $siteManager;

    protected string $viewPrefix = 'network::site';

    public function __construct(
        SiteManagerContract $siteManager
    ) {
        $this->siteManager = $siteManager;
    }

    public function loginToken(Request $request): RedirectResponse
    {
        $user = $this->siteManager->validateLoginUrl($request->all());

        if (empty($user)) {
            abort(403, 'Login Token invalid');
        }

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function addMappingDomain(AddMappingDomainRequest $request, $id): JsonResponse|RedirectResponse
    {
        $site = Site::findOrFail($id);

        $site->domainMappings()->create($request->all());

        return $this->success(
            [
                'message' => __('Add Mapping Domain success'),
                'redirect' => route('admin.network.sites.edit', [$id])
            ]
        );
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
        $data['mappingMomains'] = $model->domainMappings()->get();
        return $data;
    }

    protected function storeSuccess($request, $model, ...$params): void
    {
        $this->siteManager->getCreater()->setupSite($model);
    }
}
