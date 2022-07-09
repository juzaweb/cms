<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Support\Collection;

interface HookActionContract
{
    public function addAction($tag, $callback, $priority = 20, $arguments = 1): void;

    public function addFilter($tag, $callback, $priority = 20, $arguments = 1): void;

    public function addSettingForm(string $key, array $args = []): void;

    public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void;

    public function addMasterAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void;

    public function applyFilters(string $tag, mixed $value, ...$args): mixed;

    public function getMenuBoxs(array $keys = []): array;

    public function enqueueScript(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void;

    public function enqueueStyle(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void;

    public function enqueueFrontendScript(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false
    ): void;

    public function enqueueFrontendStyle(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false
    ): void;

    public function getProfilePages($key = null): Collection;

    public function registerPermission(string $key, array $args = []): void;

    public function registerResourcePermissions(string $resource, string $name): void;

    public function getPermissions(string $key = null): Collection;
}
