<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Support;

use Illuminate\Database\ConnectionResolverInterface;
use Juzaweb\Network\Contracts\NetworkSiteContract;
use Juzaweb\Network\Contracts\SiteCreaterContract;
use Juzaweb\Network\Contracts\SiteManagerContract;
use Juzaweb\Network\Models\Site;

class SiteManager implements SiteManagerContract
{
    protected ConnectionResolverInterface $db;

    protected SiteCreaterContract $siteCreater;

    public function __construct(
        ConnectionResolverInterface $db,
        SiteCreaterContract $siteCreater
    ) {

        $this->db = $db;

        $this->siteCreater = $siteCreater;
    }

    public function find(string|int|Site $site): ?NetworkSiteContract
    {
        if (is_numeric($site)) {
            $site = Site::find($site);
        }

        if (is_string($site)) {
            $site = Site::where(['domain' => $site])->first();
        }

        if (empty($site)) {
            return null;
        }

        return $this->createSite($site);
    }

    public function create(string $subdomain, array $args = []): NetworkSiteContract
    {
        $site = $this->siteCreater->create($subdomain, $args);

        return $this->createSite($site);
    }

    public function getCreater(): SiteCreaterContract
    {
        return $this->siteCreater;
    }

    private function createSite(Site $site): NetworkSiteContract
    {
        return new NetworkSite($site);
    }
}
