<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Theme;

use Illuminate\Cache\CacheManager;
use Juzaweb\Models\ThemeConfig as ConfigModel;
use Illuminate\Container\Container;

class ThemeConfig
{
    protected $configs;
    protected $theme;
    protected $cacheKey = 'jw_theme_configs_';

    /**
     * @var CacheManager
     */
    protected $cache;

    public function __construct(Container $app, $theme)
    {
        $this->cache = $app['cache'];
        $this->theme = $theme;

        $this->configs = $this->cache
            ->store('file')
            ->rememberForever($this->cacheKey, function () {
                return ConfigModel::where('theme', '=', $this->theme)
                    ->get([
                        'code',
                        'value',
                    ])->keyBy('code')
                    ->map(function ($item) {
                        return $item->value;
                    })
                    ->toArray();
            });
    }

    public function getConfig($key, $default = null)
    {
        $value = $this->configs[$key] ?? $default;
        if (is_json($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    public function setConfig($key, $value = null)
    {
        if (is_array($value)) {
            $value = array_merge(get_config($key, []), $value);
            $value = json_encode($value);
        }

        $config = ConfigModel::updateOrCreate([
            'code' => $key,
            'theme' => $this->theme,
        ], [
            'value' => $value,
        ]);

        $this->configs[$key] = $value;
        $this->cache->store('file')->forever($this->cacheKey, $this->configs);

        return $config;
    }
}
