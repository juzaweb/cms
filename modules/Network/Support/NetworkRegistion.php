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

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Juzaweb\Network\Contracts\NetworkRegistionContract;
use Juzaweb\Network\Models\Site;

class NetworkRegistion implements NetworkRegistionContract
{
    protected Application $app;

    protected ConfigRepository $config;

    protected CacheManager $cache;

    protected Request $request;

    protected DatabaseManager $db;

    protected object $site;

    public function __construct(
        Application $app,
        ConfigRepository $config,
        Request $request,
        CacheManager $cache,
        DatabaseManager $db
    ) {
        $this->app = $app;
        $this->config = $config;
        $this->cache = $cache;
        $this->request = $request;
        $this->db = $db;
    }

    public function init(): void
    {
        if (! $this->app->runningInConsole()) {
            $this->setupSite();
        } else {
            $this->site = $this->getRootSite();
        }
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

    protected function setupSite(): void
    {
        $currentSite = $this->getCurrentSiteInfo();

        $this->site = $currentSite->site;

        if (empty($this->site)) {
            abort(404, 'Site not found.');
        }

        if ($this->site->status == Site::STATUS_BANNED) {
            abort(403, 'Site has been banned.');
        }

        $this->config->set('juzaweb.plugin.enable_upload', false);
        $this->config->set('juzaweb.theme.enable_upload', false);

        $connection = $this->db->getDefaultConnection();

        if (!is_null($this->site->id)) {
            $prefix = $this->db->getTablePrefix() . "site{$this->site->id}_";
            $database = $this->config->get("database.connections.{$connection}");
            $database['prefix'] = $prefix;

            $this->config->set(
                'database.connections.subsite',
                $database
            );

            $this->config->set('database.default', 'subsite');

            $this->db->purge('subsite');

            $this->setCachePrefix("jw_site_{$this->site->id}");
        }

        $this->site->root_connection = $connection;

        $GLOBALS['jw_site'] = $this->site;
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

                $site = $this->db->table('network_sites')
                    ->where(
                        function ($q) use ($domain) {
                            $q->where('domain', '=', $domain);
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

    protected function setCachePrefix($prefix): void
    {
        $this->config->set('cache.prefix', $prefix);

        $this->config->set('database.redis.options.prefix', $prefix);

        $this->config->set('juzaweb.cache_prefix', $prefix);
    }
}
