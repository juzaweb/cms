<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Support;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Juzaweb\CMS\Facades\Config as DbConfig;
use Juzaweb\Network\Contracts\SiteCreaterContract;
use Juzaweb\Network\Contracts\SiteSetupContract;
use Juzaweb\Network\Models\Site;

class SiteCreater implements SiteCreaterContract
{
    protected ConnectionResolverInterface $db;

    protected ConfigRepository $config;

    protected SiteSetupContract $siteSetup;

    public function __construct(
        ConnectionResolverInterface $db,
        ConfigRepository $config,
        SiteSetupContract $siteSetup
    ) {
        $this->db = $db;

        $this->config = $config;

        $this->siteSetup = $siteSetup;
    }

    public function create(string $subdomain, array $args = []): Site
    {
        if (Site::where('domain', '=', $subdomain)->exists()) {
            throw new \Exception("Site {$subdomain} already exist.");
        }

        $data = array_merge($this->parseDataSite($args), ['domain' => $subdomain]);

        $site = Site::create($data);

        $this->setupSite($site);

        $this->makeDefaultConfigs();

        return $site;
    }

    public function setupSite(Site $site)
    {
        $this->siteSetup->setup($site);

        Artisan::call('migrate', ['--force' => true]);

        $artisanOutput = Artisan::output();

        if (in_array("Error", str_split($artisanOutput, 5))) {
            throw new \Exception($artisanOutput);
        }
    }

    protected function makeDefaultConfigs(): void
    {
        DbConfig::setConfig('title', 'JuzaCMS - Laravel CMS for Your Project');
        DbConfig::setConfig(
            'description',
            'Juzacms is a Content Management System (CMS)'
            . ' and web platform whose sole purpose is to make your development workflow simple again.'
        );
        DbConfig::setConfig('author_name', 'Juzaweb Team');
        DbConfig::setConfig('user_registration', 1);
        DbConfig::setConfig('user_verification', 0);
    }

    protected function parseDataSite(array $args): array
    {
        $defaults = ['status' => Site::STATUS_ACTIVE];

        return array_merge($defaults, Arr::get($args, 'site', []));
    }
}
