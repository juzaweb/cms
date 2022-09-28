<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\Traits\Macroable;

class CacheGroup
{
    use Macroable;

    protected CacheManager $cache;

    protected string $store = 'file';

    public function __construct($cache)
    {
        $this->cache = $cache;
    }

    public function driver(string $driver = 'file'): self
    {
        $this->store = $driver;

        return $this;
    }

    public function add(
        string $group,
        string $key,
        int|null $ttl = null
    ): void {
        $keys = $this->get($group);
        $keys[$key] = $key;
        $this->cache->store($this->store)->put($group, $keys, $ttl);
    }

    public function get(string $group): array
    {
        return $this->cache->store($this->store)->get($group, []);
    }

    public function pull(string $group): void
    {
        $keys = array_keys($this->get($group));
        foreach ($keys as $key) {
            $this->cache->store($this->store)->pull($key);
        }

        $this->cache->store($this->store)->pull($group);
    }
}
