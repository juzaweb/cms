<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Console\Command;
use Juzaweb\CMS\Contracts\TranslationManager;

class ImportTranslationCommand extends Command
{
    protected $name = 'plugin:import-translation';

    public function handle(): int
    {
        $import = app(TranslationManager::class)->import('plugin', 'juzaweb/ecommerce');

        $this->info("Import success {$import} language text.");

        return self::SUCCESS;
    }
}
