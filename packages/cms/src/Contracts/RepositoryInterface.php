<?php

namespace Juzaweb\Contracts;

use Juzaweb\Abstracts\Plugin;
use Juzaweb\Exceptions\ModuleNotFoundException;

interface RepositoryInterface
{
    /**
     * Get all plugins.
     *
     * @return mixed
     */
    public function all();

    /**
     * Get cached plugins.
     *
     * @return array
     */
    public function getCached();

    /**
     * Scan & get all available plugins.
     *
     * @return array
     */
    public function scan();

    /**
     * Get plugins as plugins collection instance.
     *
     * @return \Juzaweb\Support\Collection
     */
    public function toCollection();

    /**
     * Get scanned paths.
     *
     * @return array
     */
    public function getScanPaths();

    /**
     * Get list of enabled plugins.
     *
     * @return mixed
     */
    public function allEnabled();

    /**
     * Get list of disabled plugins.
     *
     * @return mixed
     */
    public function allDisabled();

    /**
     * Get count from all plugins.
     *
     * @return int
     */
    public function count();

    /**
     * Get all ordered plugins.
     * @param string $direction
     * @return mixed
     */
    public function getOrdered($direction = 'asc');

    /**
     * Get plugins by the given status.
     *
     * @param int $status
     *
     * @return mixed
     */
    public function getByStatus($status);

    /**
     * Find a specific plugin.
     *
     * @param $name
     * @return Module|null
     */
    public function find(string $name);

    /**
     * Find all plugins that are required by a plugin. If the plugin cannot be found, throw an exception.
     *
     * @param $name
     * @return array
     * @throws ModuleNotFoundException
     */
    public function findRequirements($name): array;

    /**
     * Find a specific plugin. If there return that, otherwise throw exception.
     *
     * @param $name
     *
     * @return mixed
     */
    public function findOrFail(string $name);

    public function getModulePath($moduleName);

    /**
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFiles();

    /**
     * Get a specific config data from a configuration file.
     * @param string $key
     *
     * @param string|null $default
     * @return mixed
     */
    public function config(string $key, $default = null);

    /**
     * Get a plugin path.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Find a specific plugin by its alias.
     * @param string $alias
     * @return Plugin|void
     */
    public function findByAlias(string $alias);

    /**
     * Boot the plugins.
     */
    public function boot(): void;

    /**
     * Register the plugins.
     */
    public function register(): void;

    /**
     * Get asset path for a specific plugin.
     *
     * @param string $module
     * @return string
     */
    public function assetPath(string $module): string;

    /**
     * Delete a specific plugin.
     * @param string $module
     * @return bool
     * @throws \Juzaweb\Exceptions\ModuleNotFoundException
     */
    public function delete(string $module): bool;

    /**
     * Determine whether the given plugin is activated.
     * @param string $name
     * @return bool
     * @throws ModuleNotFoundException
     */
    public function isEnabled(string $name): bool;

    /**
     * Determine whether the given plugin is not activated.
     * @param string $name
     * @return bool
     * @throws ModuleNotFoundException
     */
    public function isDisabled(string $name): bool;
}
