<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Theme;

use Illuminate\Cache\CacheManager;
use Juzaweb\CMS\Contracts\ThemeConfigContract;
use Juzaweb\CMS\Models\ThemeConfig as ConfigModel;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

class ThemeConfig implements ThemeConfigContract
{
    protected array $configs;
    protected string $theme;
    protected string $cacheKey = 'jw_theme_configs';

    /**
     * @var CacheManager
     */
    protected CacheManager $cache;

    public function __construct(Container $app, $theme)
    {
        $this->cache = $app['cache'];
        $this->theme = $theme;

        $this->configs = $this->cache
            ->store('file')
            ->rememberForever(
                $this->getCacheKey(),
                function () {
                    return ConfigModel::where('theme', '=', $this->theme)
                        ->get(
                            [
                                'code',
                                'value',
                            ]
                        )
                        ->keyBy('code')
                        ->map(
                            function ($item) {
                                return $item->value;
                            }
                        )
                        ->toArray();
                }
            );
    }

    public function getConfig(string $key, string|array $default = null): null|string|array
    {
        $value = $this->configs[$key] ?? $default;

        if (is_json($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    public function getConfigs(array $keys, string|array $default = null): array
    {
        $configs = [];
        foreach ($keys as $key) {
            $configs[$key] = $this->getConfig($key, $default);
        }
        return $configs;
    }

    public function setConfig(string $key, string|array $value = null): Model|ConfigModel
    {
        if (is_array($value)) {
            $value = array_merge(get_config($key, []), $value);
            $value = json_encode($value);
        }

        $config = ConfigModel::updateOrCreate(
            [
                'code' => $key,
                'theme' => $this->theme,
            ],
            [
                'value' => $value,
            ]
        );

        $this->configs[$key] = $value;

        $this->cache->store('file')->forever($this->getCacheKey(), $this->configs);

        return $config;
    }

    protected function getCacheKey(): string
    {
        return cache_prefix("{$this->cacheKey}_{$this->theme}");
    }
}
