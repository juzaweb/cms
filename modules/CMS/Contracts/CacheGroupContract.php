<?php

namespace Juzaweb\CMS\Contracts;

interface CacheGroupContract
{
    public function add(string $group, string $key, int|null $ttl = null): void;

    public function get(string $group): array;

    public function pull(string $group): void;
}
