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
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Support\Updater\ThemeUpdater;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ThemeUpdateCommand extends Command
{
    protected $name = 'theme:update';

    protected $description = 'Update dependencies for the specified theme or for all themes.';

    public function handle(): int
    {
        $name = $this->argument('theme');

        if ($name) {
            $this->update($name);

            return self::SUCCESS;
        }

        foreach (Theme::all() as $name => $info) {
            $this->update($name);
        }

        return self::SUCCESS;
    }

    protected function update($name)
    {
        $this->line('Running for theme: <info>' . $name . '</info>');

        $this->info('Check file update');

        $updater = app(ThemeUpdater::class)->find($name);

        $check = $updater->checkForUpdate();

        $force = $this->option('force');

        if (empty($check) && !$force) {
            $this->warn("Plugin [{$name}] no new version available.");
            return;
        }

        $this->info('Fetch Data');
        $updater->fetchDataUpdate();

        $this->info('Download File');
        $updater->downloadUpdateFile();

        $this->info('Unzip File');
        $updater->unzipFile();

        $this->info('Move to folder');
        $updater->updateFileAndFolder();

        $this->info('Update database');
        $updater->finish();

        $this->info('Plugin updated successful.');
    }

    protected function getArguments(): array
    {
        return [
            ['theme', InputArgument::OPTIONAL, 'The name of theme will be updated.'],
        ];
    }

    public function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_OPTIONAL, 'Force the operation to run update.', false],
        ];
    }
}
