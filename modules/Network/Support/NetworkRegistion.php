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

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Juzaweb\Network\Contracts\NetworkRegistionContract;
use Juzaweb\Network\Contracts\SiteSetupContract;
use Juzaweb\Network\Models\Site;
use Illuminate\Support\Facades\URL;

class NetworkRegistion implements NetworkRegistionContract
{
    protected Application $app;

    protected ConfigRepository $config;

    protected CacheManager $cache;

    protected Request $request;

    protected DatabaseManager $db;

    protected SiteSetupContract $siteSetup;

    protected Kernel $kernel;

    protected ?object $site;

    public function __construct(
        Application $app,
        ConfigRepository $config,
        Request $request,
        CacheManager $cache,
        DatabaseManager $db,
        SiteSetupContract $siteSetup,
        Kernel $kernel
    ) {
        $this->app = $app;
        $this->config = $config;
        $this->cache = $cache;
        $this->request = $request;
        $this->db = $db;
        $this->siteSetup = $siteSetup;
        $this->kernel = $kernel;
    }

    public function init(): void
    {
        if (! $this->app->runningInConsole()) {
            $this->setupSite();
        } else {
            $argv = $_SERVER['argv'];
            if (($argv[0] ?? '') == 'artisan' && ($argv[1] ?? '') == 'network:run') {
                $siteID = intval($argv[3]);
                $site = $this->db->table('network_sites')
                    ->where(['id' => $siteID])
                    ->first();
                if (!$site) {
                    throw new \Exception("Can not find site {$siteID}");
                }

                $this->site = $site;

                $this->siteSetup->setup($site);

                $baseDomain = $this->config->get('network.domain');

                $host = parse_url($this->config->get('app.url'));

                $this->config->set('app.url', "{$host['scheme']}://{$site->domain}.{$baseDomain}");

                URL::forceRootUrl("{$host['scheme']}://{$site->domain}.{$baseDomain}");
            } else {
                $this->site = $this->getRootSite();
            }
        }

        $GLOBALS['site'] = $this->site;
    }

    public function getCurrentSite(): object
    {
        return $this->site;
    }

    public function isRootSite($domain = null): bool
    {
        if (empty($domain)) {
            return is_null($this->site->id);
        }

        return $domain == $this->config->get('network.domain');
    }

    public function getCurrentDomain(): string
    {
        return $this->request->getHttpHost();
    }

    public function getCurrentSiteId(): ?int
    {
        return $this->getCurrentSite()->id;
    }

    protected function setupSite(): void
    {
        $this->site = $this->getCurrentSiteInfo()->site;

        if (empty($this->site)) {
            abort(404, 'Site not found.');
        }

        if ($this->site->status == Site::STATUS_BANNED) {
            abort(403, 'Site has been banned.');
        }

        $this->site = $this->siteSetup->setup($this->site);
    }

    protected function getCurrentSiteInfo(): object
    {
        $domain = $this->getCurrentDomain();

        return $this->cache->rememberForever(
            md5($domain),
            function () use ($domain) {
                if ($domain == $this->config->get('network.domain')) {
                    $site = $this->getRootSite();

                    return (object) ['site' => $site];
                }

                $subdomain = str_replace("." . $this->config->get('network.domain'), "", $domain);

                $site = $this->db->table('network_sites')
                    ->where(
                        function ($q) use ($domain, $subdomain) {
                            $q->where('domain', '=', $subdomain);
                            $q->orWhereExists(
                                function ($q2) use ($domain) {
                                    $q2->select(['id']);
                                    $q2->from('network_domain_mappings');
                                    $q2->whereColumn('network_domain_mappings.site_id', '=', 'network_sites.id');
                                    $q2->where('domain', '=', $domain);
                                }
                            );
                        }
                    )
                    ->first();

                return (object) ['site' => $site];
            }
        );
    }

    protected function getRootSite(): object
    {
        return (object) [
            'id' => null,
            'status' => Site::STATUS_ACTIVE,
        ];
    }
}
