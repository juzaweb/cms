<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Contracts\ConfigContract;
use Juzaweb\CMS\Models\Config as ConfigModel;
use Illuminate\Container\Container;

class Config implements ConfigContract
{
    protected array $configs = [];

    /**
     * @var CacheManager
     */
    protected CacheManager $cache;

    public function __construct(Container $app, CacheManager $cache)
    {
        $this->cache = $cache;
        if (Installer::alreadyInstalled()) {
            $this->configs = $this->cache
                ->store('file')
                ->rememberForever(
                    $this->getCacheKey(),
                    function () {
                        return ConfigModel::get(
                            [
                                'code',
                                'value',
                            ]
                        )->keyBy('code')
                            ->map(
                                function ($item) {
                                    return $item->value;
                                }
                            )
                            ->toArray();
                    }
                );
        }
    }

    public function getConfig($key, $default = null): mixed
    {
        $configKeys = explode('.', $key);
        $value = $this->configs[$configKeys[0]] ?? $default;
        if (is_json($value)) {
            $value = json_decode($value, true);
            if (count($configKeys) > 1) {
                unset($configKeys[0]);
                $value = Arr::get($value, implode('.', $configKeys), $default);
            }
        }

        return $value;
    }

    public function setConfig($key, $value = null): ConfigModel
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $config = ConfigModel::updateOrCreate(
            [
                'code' => $key,
            ],
            [
                'value' => $value,
            ]
        );

        $this->configs[$key] = $value;
        $this->cache->store('file')->forever(
            $this->getCacheKey(),
            $this->configs
        );

        return $config;
    }

    protected function getCacheKey(): string
    {
        return cache_prefix('jw_configs_');
    }
}
