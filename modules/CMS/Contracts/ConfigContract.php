<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Support\Collection;
use Juzaweb\CMS\Models\Config;
use Juzaweb\CMS\Models\Config as ConfigModel;

interface ConfigContract
{
    /**
     * Retrieves the value of a configuration key.
     *
     * @param string $key The configuration key to retrieve.
     * @param string|array|null $default The default value to return if the key is not found.
     * @throws Some_Exception_Class If an error occurs while retrieving the configuration.
     * @return null|string|array The value of the configuration key.
     */
    public function getConfig(string $key, string|array $default = null): null|string|array;

    /**
     * Sets a configuration value for the application.
     *
     * @param string $key The key of the configuration.
     * @param string|array|null $value The value of the configuration.
     * @return ConfigModel The updated or created ConfigModel instance.
     */
    public function setConfig(string $key, string|array $value = null): ConfigModel;

    /**
     * Retrieves the configuration values for the given keys and returns them in an array.
     *
     * @param array $keys The keys for which the configuration values are to be retrieved.
     * @param mixed $default The default value to be used if a configuration value is not found for a key. Defaults to null.
     * @return array The configuration values for the given keys in an array.
     */
    public function getConfigs(array $keys, string|array $default = null): array;

    /**
     * Retrieves all the values from the configs and applies a transformation to each value.
     *
     * @return Collection A collection containing the transformed values.
     */
    public function all(): Collection;
}
