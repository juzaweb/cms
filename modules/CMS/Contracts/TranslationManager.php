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
use Juzaweb\CMS\Models\Translation;
use Juzaweb\CMS\Support\Translations\TranslationExporter;
use Juzaweb\CMS\Support\Translations\TranslationImporter;
use Juzaweb\CMS\Support\Translations\TranslationLocale;
use Juzaweb\CMS\Support\Translations\TranslationTranslate;

/**
 * @see \Juzaweb\CMS\Support\Manager\TranslationManager
 */
interface TranslationManager
{
    /**
     * @see \Juzaweb\CMS\Support\Manager\TranslationManager::import()
     */
    public function import(string $module, string $name = null): TranslationImporter;

    public function translate(
        string $source,
        string $target,
        string $module = 'cms',
        string $name = 'core'
    ): TranslationTranslate;

    public function export(string $module = 'cms', string $name = null): TranslationExporter;

    public function locale(string|Collection $module, string $name = null): TranslationLocale;

    public function modules(): Collection;

    /**
     * @see \Juzaweb\CMS\Support\Manager\TranslationManager::importTranslationLine()
     */
    public function importTranslationLine(array $data): Translation;
}
