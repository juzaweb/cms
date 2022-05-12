<?php

namespace Juzaweb\CMS\Contracts;

interface ThemeContract
{
    public function set(string $theme): void;

    public function get(string $theme = null, bool $collection = false): ?array;

    public function all(bool $assoc = false): array;
}
