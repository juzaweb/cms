<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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

    public function getConfig(string $key, string|array $default = null): null|string|array
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

    public function setConfig(string $key, string|array $value = null): ConfigModel
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

    public function getConfigs(array $keys, mixed $default = null): array
    {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $this->getConfig($key, $default);
        }

        return $data;
    }

    public function all(): Collection
    {
        return collect($this->configs)->map(
            function ($value) {
                if (is_json($value)) {
                    return json_decode($value, true);
                }

                return $value;
            }
        );
    }

    protected function getCacheKey(): string
    {
        return cache_prefix('jw_configs_');
    }
}
