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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Network\Http\Requests\MappingDomain\StoreRequest;
use Juzaweb\Network\Models\Site;

class MappingDomainController extends BackendController
{
    public function store(StoreRequest $request, $siteId): JsonResponse|RedirectResponse
    {
        $site = Site::findOrFail($siteId);

        $site->domainMappings()->create($request->all());

        return $this->success(
            [
                'message' => __('Add Mapping Domain success'),
                'redirect' => route('admin.network.sites.edit', [$siteId])
            ]
        );
    }

    public function destroy($siteId, $id): JsonResponse|RedirectResponse
    {
        $site = Site::findOrFail($siteId);

        $domain = $site->domainMappings()->find($id);

        $domain->delete();

        return $this->success(
            [
                'message' => __('Delete successful Mapping Domain :domain', ['domain' => $domain->domain]),
                'redirect' => route('admin.network.sites.edit', [$id])
            ]
        );
    }
}
