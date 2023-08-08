<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
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
     * Find a module by name or collection.
     *
     * @param string|Collection $module The module or collection to find.
     * @param string $name The name of the module to find.
     * @throws \Exception If the module or collection is not found.
     * @return Collection The found module or collection.
     */
    public function find(string|Collection $module, string $name = null): Collection;

    /**
     * Import a translation module and create a TranslationImporter instance.
     *
     * @param string $module The name of the translation module to import.
     * @param string|null $name The optional name of the translation.
     * @return TranslationImporter The created TranslationImporter instance.
     * @see \Juzaweb\CMS\Support\Manager\TranslationManager::import()
     */
    public function import(string $module, string $name = null): TranslationImporter;

    /**
     * Translates a source string to a target string.
     *
     * @param string $source The source string to be translated.
     * @param string $target The target language for the translation.
     * @param string $module The module to use for translation. Default value is 'cms'.
     * @param string $name The name of the module. Default value is 'core'.
     * @return TranslationTranslate The translation object with the source and target strings set.
     */
    public function translate(
        string $source,
        string $target,
        string $module = 'cms',
        string $name = 'core'
    ): TranslationTranslate;

    /**
     * Export translations for a specific module.
     *
     * @param string $module The name of the module to export translations for. Default is 'cms'.
     * @param string|null $name The name of the translation file. If provided, only translations for this file will be exported.
     * @return TranslationExporter The TranslationExporter object for exporting translations.
     */
    public function export(string $module = 'cms', string $name = null): TranslationExporter;

    /**
     * Retrieves the translation locale for a given module and name.
     *
     * @param string|Collection $module The module or collection name.
     * @param string|null $name The locale name.
     * @return TranslationLocale The translation locale object.
     */
    public function locale(string|Collection $module, string $name = null): TranslationLocale;

    /**
     * Retrieves a collection of modules.
     *
     * @return Collection A collection of modules.
     */
    public function modules(): Collection;

    /**
     * @see \Juzaweb\CMS\Support\Manager\TranslationManager::importTranslationLine()
     */
    public function importTranslationLine(array $data): Translation;
}
