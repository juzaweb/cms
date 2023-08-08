<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\DevTool\Commands\Theme;

use Illuminate\Console\Command;
use Juzaweb\CMS\Contracts\TranslationManager;
use Symfony\Component\Console\Input\InputArgument;

class TranslateViaGoogleCommand extends Command
{
    protected $name = 'theme:google-translate';

    public function handle(): int
    {
        $translate = app(TranslationManager::class)->translate(
            $this->argument('source'),
            $this->argument('target'),
            'theme',
            $this->argument('theme')
        );

        $bar = $this->output->createProgressBar($translate->getTranslationLines()->count());
        $bar->start();

        $translate->progressCallback(
            function ($model) use ($bar) {
                $bar->advance();
            }
        );

        $result = $translate->run();

        $bar->finish();

        $this->newLine();
        $this->info("Translate success {$result} language text.");

        if ($errors = $translate->getErrors()) {
            $this->error(join("\n - ", $errors));
        }

        return self::SUCCESS;
    }

    protected function getArguments(): array
    {
        return [
            ['theme', InputArgument::REQUIRED, 'The name of theme will be import.'],
            ['source', InputArgument::REQUIRED, 'Source translate language.'],
            ['target', InputArgument::REQUIRED, 'Target translate language.'],
        ];
    }
}
