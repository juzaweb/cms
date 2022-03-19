<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support;

use Illuminate\Cache\CacheManager;
use Juzaweb\Facades\Site;
use Juzaweb\Models\Config as ConfigModel;
use Illuminate\Container\Container;

class Config
{
    protected $configs = [];

    /**
     * @var CacheManager
     */
    protected $cache;

    public function __construct(Container $app)
    {
        $this->cache = $app['cache'];
        if (Installer::alreadyInstalled()) {
            $this->configs = $this->cache
                ->store('file')
                ->rememberForever(
                    $this->getCacheKey(),
                    function () {
                        return ConfigModel::where('site_id', '=', Site::info()->id)
                            ->get([
                                'code',
                                'value',
                            ])->keyBy('code')
                            ->map(function ($item) {
                                return $item->value;
                            })
                            ->toArray();
                    }
                );
        }
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
            $value = json_encode($value);
        }

        $config = ConfigModel::updateOrCreate([
            'code' => $key,
        ], [
            'value' => $value,
        ]);

        $this->configs[$key] = $value;
        $this->cache->store('file')->forever(
            $this->getCacheKey(),
            $this->configs
        );

        $this->cache->store('file')->forever(
            "dbconfig_". Site::info()->id ."_{$key}",
            $value
        );

        return $config;
    }

    protected function getCacheKey()
    {
        return 'jw_configs_' . Site::info()->id;
    }
}
