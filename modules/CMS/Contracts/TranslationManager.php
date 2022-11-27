<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Support\Collection;

/**
 * @see \Juzaweb\CMS\Support\Manager\TranslationManager
 */
interface TranslationManager
{
    /**
     * @see \Juzaweb\CMS\Support\Manager\TranslationManager::import()
     */
    public function import(string $module, string $name = null): int;

    public function importLocalTranslations(string|Collection $module, string $name = null): int;

    public function importMissingKeys(string|Collection $module, string $name = null): int;

    public function translate(string $source, string $target, string $module = 'cms', string $name = 'core'): array;
}
