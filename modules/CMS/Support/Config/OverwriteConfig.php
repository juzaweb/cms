<?php

namespace Juzaweb\CMS\Support\Config;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Facades\URL;
use Juzaweb\CMS\Contracts\OverwriteConfigContract;
use Juzaweb\CMS\Support\Config as DbConfig;
use Illuminate\Http\Request;

class OverwriteConfig implements OverwriteConfigContract
{
    private ConfigRepository $config;
    private DbConfig $dbConfig;
    private Request $request;
    private $locale;

    public function __construct(
        ConfigRepository $config,
        DbConfig $dbConfig,
        Request $request,
        $locale
    ) {
        $this->config = $config;
        $this->dbConfig = $dbConfig;
        $this->request = $request;
        $this->locale = $locale;
    }

    public function init(): void
    {
        $this->setupEmail();

        $this->setupHttps();
    }

    protected function setupEmail(): void
    {
        $mail = $this->dbConfig->getConfig('email');
        $timezone = $this->dbConfig->getConfig('timezone', 'UTC');
        $language = $this->dbConfig->getConfig('language', 'en');

        $this->config->set('app.timezone', $timezone);
        date_default_timezone_set($timezone);

        $this->config->set('app.locale', $language);
        $this->locale->setLocale($language);

        if ($mail) {
            $this->config->set(
                'mail',
                [
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
                ]
            );
        }
    }

    protected function setupHttps(): void
    {
        if ($proxyUrl = $this->config->get('app.proxy_url')) {
            URL::forceRootUrl($proxyUrl);
        }

        if ($proto = $this->request->headers->get('X-Forwarded-Proto')) {
            URL::forceScheme($proto);
        }
    }
}
