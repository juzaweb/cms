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
        }
    }

    public function isRootSite($domain = null): bool
    {
        $domain = $domain ?: $this->getCurrentDomain();

        return $domain == $this->config->get('network.domain');
    }

    public function getCurrentDomain(): string
    {
        return $this->request->getHttpHost();
    }

    protected function setupSite(): void
    {
        $currentSite = $this->getCurrentSite();

        $site = $currentSite->site;

        if (empty($site)) {
            abort(404, 'Site not found.');
        }

        if ($site->status == Site::STATUS_BANNED) {
            abort(403, 'Site has been banned.');
        }

        $GLOBALS['jw_site'] = $site;

        if (!is_null($site->id)) {
            $this->config->set('juzaweb.plugin.enable_upload', false);
            $this->config->set('juzaweb.theme.enable_upload', false);

            $connection = $this->db->getDefaultConnection();
            $prefix = $this->db->getTablePrefix() . "_site{$site->id}_";

            $this->config->set(
                "database.connections.{$connection}.prefix",
                $prefix
            );
        }

        $this->setCachePrefix("jw_site_{$site->id}");
    }

    protected function getCurrentSite(): object
    {
        $domain = $this->getCurrentDomain();

        if ($this->isRootSite($domain)) {
            $site = (object) [
                'id' => null,
                'status' => Site::STATUS_ACTIVE,
            ];

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

    protected function setCachePrefix($prefix): void
    {
        $this->config->set('cache.prefix', $prefix);

        $this->config->set('database.redis.options.prefix', $prefix);

        $this->config->set('juzaweb.cache_prefix', $prefix);
    }
}
