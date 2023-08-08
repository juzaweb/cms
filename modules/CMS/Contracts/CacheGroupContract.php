<?php

namespace Juzaweb\CMS\Contracts;

interface CacheGroupContract
{
    /**
     * Sets the driver for the storage.
     *
     * @param string $driver The driver to use for storage. Default is 'file'.
     * @return self
     */
    public function driver(string $driver = 'file'): self;

    /**
     * Adds a key to the specified group in the cache.
     *
     * @param string $group The name of the group.
     * @param string $key The key to add.
     * @param int|null $ttl The time-to-live for the key, in seconds. Defaults to null.
     * @return void
     */
    public function add(string $group, string $key, int|null $ttl = null): void;

    /**
     * Retrieves an array of items from the cache for the given group.
     *
     * @param string $group The group to retrieve the items from.
     * @return array The retrieved items from the cache.
     */
    public function get(string $group): array;

    /**
     * Pulls the specified group from the cache.
     *
     * @param string $group The name of the group to pull.
     * @return void
     */
    public function pull(string $group): void;
}
