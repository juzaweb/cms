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
use Illuminate\Http\Request;
use Juzaweb\Network\Contracts\NetworkRegistionContract;

class NetworkRegistion implements NetworkRegistionContract
{
    private Application $app;

    private ConfigRepository $config;

    private CacheManager $cache;

    private Request $request;

    public function __construct(
        Application $app,
        ConfigRepository $config,
        $request,
        CacheManager $cache
    ) {
        $this->app = $app;
        $this->config = $config;
        $this->cache = $cache;
        $this->request = $request;
    }

    public function init(): void
    {
        if (!$this->app->runningInConsole()) {
            $this->setupSite();
        }
    }

    protected function setupSite(): void
    {
        $GLOBALS['jw_site'] = $site['site'];
    }

    private function setCachePrefix($prefix): void
    {
        $this->config->set('cache.prefix', $prefix);

        $this->config->set('database.redis.options.prefix', $prefix);

        $this->config->set('juzaweb.cache_prefix', $prefix);
    }
}
