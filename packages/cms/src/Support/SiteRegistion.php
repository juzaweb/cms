<?php

namespace Juzaweb\Support;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;
use Juzaweb\Multisite\Models\Site;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SiteRegistion
{
    protected $site;

    /**
     * @var CacheManager
     */
    private $cache;

    /**
     * @var ConfigRepository
     */
    private $config;

    public function __construct(
        Application $app,
        ConfigRepository $config,
        $request
    ) {
        $this->cache = $app['cache'];
        $this->config = $config;

        if (!$app->runningInConsole()) {
            $this->setupSite($request);

            $this->setupHttps($request);
        } else {
            $site = (object) [
                'id' => null
            ];

            $GLOBALS['site'] = $site;
            $this->site = $site;
        }
    }

    public function info()
    {
        return $this->site;
    }

    protected function setupSite($request)
    {
        $domain = $request->getHttpHost();
        $site = $this->getSiteByDomain($domain);

        $this->site = $site['site'];
        $GLOBALS['site'] = $site['site'];

        if ($site['site']->id) {
            $db = $site['db'];

            Config::set(
                'database.connections.subsite',
                array_merge(
                    Config::get('database.connections.subsite'),
                    [
                        'host' => $db->dbhost,
                        'port' => $db->dbport,
                        'database' => $db->dbname,
                        'username' => $db->dbuser,
                        'password' => (string) $db->dbpass,
                        'prefix' => (string) $db->dbprefix,
                    ]
                )
            );

            Config::set('database.default', 'subsite');

            DB::purge('subsite');
        }

        $this->setupEmail();
    }

    protected function setupEmail()
    {
        $mail = $this->getConfig('email');
        $timezone = $this->getConfig('timezone', 'UTC');
        $language = $this->getConfig('language', 'en');

        $this->config->set('app.timezone', $timezone);
        date_default_timezone_set($timezone);

        $this->config->set('app.locale', $language);

        if ($mail) {
            $mail = json_decode($mail, true);
        } else {
            $mail = $this->config->get('juzaweb.email.default');
        }

        $config = [
            'driver' => $mail['driver'] ?? 'smtp',
            'host' => $mail['host'] ?? '',
            'port' => $mail['port'] ?? '',
            'from' => [
                'address' => $mail['from_address'] ?? '',
                'name' => $mail['from_name'] ?? '',
            ],
            'encryption' => $mail['encryption'] ?? '',
            'username' => $mail['username'] ?? '',
            'password' => $mail['password'] ?? '',
        ];

        $this->config->set('mail', $config);
    }

    protected function setupHttps($request)
    {
        if ($proto = $request->headers->get('X-Forwarded-Proto')) {
            URL::forceScheme($proto);
        }
    }

    protected function getSiteByDomain($domain)
    {
        return $this->cache
            ->store('file')
            ->rememberForever(
                "site_{$domain}",
                function () use ($domain) {
                    if ($domain == config('app.domain')) {
                        $site = (object) [
                            'id' => null,
                            'status' => Site::STATUS_ACTIVE,
                        ];

                        return ['site' => $site, 'db' => null];
                    }

                    $split = explode('.', $domain);
                    $domains = explode(',', config('app.site_domains'));
                    $domains[] = 'juzaweb.com';

                    if (count($split) == 3
                        && in_array("{$split[1]}.{$split[2]}", $domains)
                    ) {
                        $site = DB::table('sites')
                            ->where('subdomain', '=', $split[0])
                            ->first();
                    } else {
                        $site = DB::table('sites')
                            ->whereExists(function ($q) use ($domain) {
                                $q->select(['id']);
                                $q->from('domain_mappings');
                                $q->whereColumn('domain_mappings.site_id', '=', 'sites.id');
                                $q->where('domain', '=', $domain);
                            })
                            ->first();
                    }

                    if (empty($site)) {
                        return [
                            'site' => (object) [
                                'id' => 0,
                                'error' => 'Site not found.'
                            ],
                            'db' => null,
                        ];
                    }

                    if ($site->status == Site::STATUS_BANNED) {
                        return [
                            'site' => (object) [
                                'id' => 0,
                                'status' => Site::STATUS_BANNED,
                                'error' => 'Site has been banned.'
                            ],
                            'db' => null,
                        ];
                    }

                    $db = DB::table('databases')
                        ->where('id', '=', $site->db_id)
                        ->first();

                    return ['site' => $site, 'db' => $db];
                }
            );
    }

    protected function getConfig($code, $default = '')
    {
        $value = $this->cache->store('file')->rememberForever(
            "dbconfig_{$this->site->id}_{$code}",
            function () use ($code) {
                $data = DB::table('configs')
                    ->where('code', '=', $code)
                    ->where('site_id', '=', $this->site->id)
                    ->first(['value']);

                if ($data) {
                    return $data->value;
                }

                return false;
            }
        );

        return $value === false ? $default : $value;
    }
}
