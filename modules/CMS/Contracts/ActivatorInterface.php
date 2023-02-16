<?php

namespace Juzaweb\CMS\Contracts;

use Juzaweb\CMS\Support\Plugin;

interface ActivatorInterface
{
    /**
     * Enables a plugin
     *
     * @param Plugin $module
     */
    public function enable(Plugin $module): void;

    /**
     * Disables a plugin
     *
     * @param Plugin $module
     */
    public function disable(Plugin $module): void;

    /**
     * Determine whether the given status same with a plugin status.
     *
     * @param Plugin $module
     * @param bool $status
     *
     * @return bool
     */
    public function hasStatus(Plugin $module, bool $status): bool;

    /**
     * Set active state for a plugin.
     *
     * @param Plugin $module
     * @param bool $active
     */
    public function setActive(Plugin $module, bool $active): void;

    /**
     * Sets a plugin status by its name
     *
     * @param  string $name
     * @param  bool $active
     */
    public function setActiveByName(string $name, bool $active): void;

    /**
     * Deletes a plugin activation status
     *
     * @param  Plugin $module
     */
    public function delete(Plugin $module): void;

    /**
     * Get plugin info load
     *
     * @param  Plugin $module
     * @return ?array
     */
    public function getAutoloadInfo(Plugin $module): ?array;

    /**
     * Deletes any plugin activation statuses created by this class.
     */
    public function reset(): void;
}
