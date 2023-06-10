<?php

namespace Juzaweb\CMS\Traits\QueryCache;

use BadMethodCallException;
use DateTime;
use Illuminate\Cache\CacheManager;
use Juzaweb\CMS\Facades\CacheGroup;

trait QueryCacheModule
{
    /**
     * The number of seconds or the DateTime instance
     * that specifies how long to cache the query.
     *
     * @var int|\DateTime
     */
    protected $cacheFor;

    /**
     * The tags for the query cache. Can be useful
     * if flushing cache for specific tags only.
     *
     * @var null|array
     */
    protected $cacheTags = null;

    /**
     * The tags for the query cache that
     * will be present on all queries.
     *
     * @var null|array
     */
    protected $cacheBaseTags = null;

    /**
     * The cache driver to be used.
     *
     * @var string
     */
    protected $cacheDriver;

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    protected $cachePrefix = 'jw_query';

    /**
     * Specify if the key that should be used when caching the query
     * need to be plain or be hashed.
     *
     * @var bool
     */
    protected $cacheUsePlainKey = false;

    /**
     * Set if the caching should be avoided.
     *
     * @var bool
     */
    protected $avoidCache = true;

    protected string $defaultGroupKey = 'query_groups';

    /**
     * Get the cache from the current query.
     *
     * @param  string  $method
     * @param  array  $columns
     * @param  string|null  $id
     * @return array
     */
    public function getFromQueryCache(string $method = 'get', array $columns = ['*'], string $id = null)
    {
        if (is_null($this->columns)) {
            $this->columns = $columns;
        }

        $key = $this->getCacheKey($method);
        $cache = $this->getCache();
        $callback = $this->getQueryCacheCallback(
            $method,
            $columns,
            $id,
            $key
        );

        $time = $this->getCacheFor();

        if ($time instanceof DateTime || $time > 0) {
            return $cache->remember($key, $time, $callback);
        }

        return $cache->rememberForever($key, $callback);
    }

    /**
     * Get the query cache callback.
     *
     * @param string $method
     * @param array|string $columns
     * @param string|null $id
     * @param string|null $key
     * @return \Closure
     */
    public function getQueryCacheCallback(
        string $method = 'get',
        $columns = ['*'],
        ?string $id = null,
        ?string $key = null
    ): \Closure {
        return function () use ($method, $columns, $key) {
            $this->avoidCache = true;

            if ($key) {
                CacheGroup::add(
                    $this->getCacheGroupKey(),
                    $key,
                    86400
                );
            }

            return $this->{$method}($columns);
        };
    }

    /**
     * Get a unique cache key for the complete query.
     *
     * @param  string  $method
     * @param  string|null  $id
     * @param  string|null  $appends
     * @return string
     */
    public function getCacheKey(string $method = 'get', string $id = null, string $appends = null): string
    {
        $key = $this->generateCacheKey($method, $id, $appends);

        $prefix = $this->getCachePrefix();

        return "{$prefix}:{$key}";
    }

    /**
     * Generate the unique cache key for the query.
     *
     * @param  string  $method
     * @param  string|null  $id
     * @param  string|null  $appends
     * @return string
     */
    public function generateCacheKey(string $method = 'get', string $id = null, string $appends = null): string
    {
        $key = $this->generatePlainCacheKey($method, $id, $appends);

        if ($this->shouldUsePlainKey()) {
            return $key;
        }

        return hash('sha256', $key);
    }

    /**
     * Generate the plain unique cache key for the query.
     *
     * @param  string  $method
     * @param  string|null  $id
     * @param  string|null  $appends
     * @return string
     */
    public function generatePlainCacheKey(string $method = 'get', string $id = null, string $appends = null): string
    {
        $name = $this->connection->getName();

        // Count has no Sql, that's why it can't be used ->toSql()
        if ($method === 'count') {
            return $name.$method.$id.serialize($this->getBindings()).$appends;
        }

        return $name.$method.$id.$this->toSql().serialize($this->getBindings()).$appends;
    }

    /**
     * Flush the cache that contains specific tags.
     *
     * @param  array  $tags
     * @return bool
     */
    public function flushQueryCache(array $tags = []): bool
    {
        $cache = $this->getCacheDriver();

        if (! method_exists($cache, 'tags')) {
            CacheGroup::driver($this->getCacheDriverName())->pull($this->getCacheGroupKey());

            return false;
        }

        if (! $tags) {
            $tags = $this->getCacheBaseTags();
        }

        foreach ($tags as $tag) {
            $this->flushQueryCacheWithTag($tag);
        }

        return true;
    }

    /**
     * Flush the cache for a specific tag.
     *
     * @param string $tag
     * @return bool
     */
    public function flushQueryCacheWithTag(string $tag): bool
    {
        $cache = $this->getCacheDriver();

        try {
            return $cache->tags($tag)->flush();
        } catch (BadMethodCallException $e) {
            CacheGroup::pull($this->getCacheGroupKey());
            return true;
        }
    }

    /**
     * Indicate that the query results should be cached.
     *
     * @param  \DateTime|int|null  $time
     * @return QueryCacheModule
     */
    public function cacheFor($time)
    {
        $this->cacheFor = $time;
        $this->avoidCache = $time === null;
        return $this;
    }

    /**
     * Indicate that the query results should be cached forever.
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function cacheForever()
    {
        return $this->cacheFor(-1);
    }

    /**
     * Indicate that the query should not be cached.
     *
     * @param  bool  $avoidCache
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function dontCache(bool $avoidCache = true)
    {
        $this->avoidCache = $avoidCache;

        return $this;
    }

    /**
     * Alias for dontCache().
     *
     * @param  bool  $avoidCache
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function doNotCache(bool $avoidCache = true)
    {
        return $this->dontCache($avoidCache);
    }

    /**
     * Set the cache prefix.
     *
     * @param  string  $prefix
     * @return QueryCacheModule
     */
    public function cachePrefix(string $prefix)
    {
        $this->cachePrefix = $prefix;

        return $this;
    }

    /**
     * Attach tags to the cache.
     *
     * @param  array  $cacheTags
     * @return QueryCacheModule
     */
    public function cacheTags(array $cacheTags = [])
    {
        $this->cacheTags = $cacheTags;

        return $this;
    }

    /**
     * Append tags to the cache.
     *
     * @param  array  $cacheTags
     * @return QueryCacheModule
     */
    public function appendCacheTags(array $cacheTags = [])
    {
        $this->cacheTags = array_unique(array_merge($this->cacheTags ?? [], $cacheTags));

        return $this;
    }

    /**
     * Use a specific cache driver.
     *
     * @param  string  $cacheDriver
     * @return QueryCacheModule
     */
    public function cacheDriver(string $cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;

        return $this;
    }

    /**
     * Set the base cache tags; the tags
     * that will be present on all cached queries.
     *
     * @param  array  $tags
     * @return QueryCacheModule
     */
    public function cacheBaseTags(array $tags = [])
    {
        $this->cacheBaseTags = $tags;

        return $this;
    }

    /**
     * Use a plain key instead of a hashed one in the cache driver.
     *
     * @param  bool  $usePlainKey
     * @return QueryCacheModule
     */
    public function withPlainKey(bool $usePlainKey = true)
    {
        $this->cacheUsePlainKey = $usePlainKey;

        return $this;
    }

    /**
     * Get the cache driver.
     *
     * @return CacheManager
     */
    public function getCacheDriver()
    {
        return app('cache')->driver($this->getCacheDriverName());
    }

    public function getCacheDriverName()
    {
        if ($this->cacheDriver) {
            return $this->cacheDriver;
        }

        return config(
            'juzaweb.performance.query_cache.driver',
            'file'
        );
    }

    /**
     * Get the cache object with tags assigned, if applicable.
     *
     * @return CacheManager
     */
    public function getCache()
    {
        $cache = $this->getCacheDriver();

        $tags = array_merge(
            $this->getCacheTags() ?: [],
            $this->getCacheBaseTags() ?: []
        );

        try {
            return $tags ? $cache->tags($tags) : $cache;
        } catch (BadMethodCallException $e) {
            return $cache;
        }
    }

    /**
     * Check if the cache operation should be avoided.
     *
     * @return bool
     */
    public function shouldAvoidCache(): bool
    {
        return $this->avoidCache;
    }

    /**
     * Check if the cache operation key should use a plain
     * query key.
     *
     * @return bool
     */
    public function shouldUsePlainKey(): bool
    {
        return $this->cacheUsePlainKey;
    }

    /**
     * Get the cache time attribute.
     *
     * @return null|int|\DateTime
     */
    public function getCacheFor(): null|DateTime|int
    {
        return $this->cacheFor;
    }

    /**
     * Get the cache tags attribute.
     *
     * @return array|null
     */
    public function getCacheTags(): ?array
    {
        return $this->cacheTags;
    }

    /**
     * Get the base cache tags attribute.
     *
     * @return array|null
     */
    public function getCacheBaseTags(): ?array
    {
        return $this->cacheBaseTags;
    }

    /**
     * Get the cache prefix attribute.
     *
     * @return string
     */
    public function getCachePrefix(): string
    {
        return cache_prefix($this->cachePrefix);
    }

    public function getCacheGroupKey(): string
    {
        return $this->getCachePrefix(). $this->defaultGroupKey;
    }
}
