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

use Juzaweb\CMS\Models\Translation;
use Juzaweb\CMS\Support\Translations\TranslationImporter;

/**
 * @see \Juzaweb\CMS\Support\Manager\TranslationManager
 */
interface TranslationManager
{
    /**
     * @see \Juzaweb\CMS\Support\Manager\TranslationManager::import()
     */
    public function import(string $module, string $name = null): TranslationImporter;

    public function translate(string $source, string $target, string $module = 'cms', string $name = 'core'): array;

    public function importTranslationLine(array $data): Translation;
}
