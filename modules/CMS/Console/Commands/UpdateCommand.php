<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Console\Commands;

use Illuminate\Console\Command;
use Juzaweb\CMS\Support\Updater\CmsUpdater;

class UpdateCommand extends Command
{
    protected $signature = 'juzacms:update';

    public function handle(CmsUpdater $updater): int
    {
        if (!$updater->checkForUpdate()) {
            $this->info('Everything up-to-date');
            return self::SUCCESS;
        }

        $this->info('Updating...');
        try {
            $this->info('-- Fetch data update');
            $updater->fetchData();
            $this->info('-- Download update file');
            $updater->downloadUpdateFile();
            $this->info('-- Unzip file');
            $updater->unzipFile();
            $this->info('-- Update files and folders');
            $updater->updateFileAndFolder();
            $this->info('-- Finish');
            $updater->finish();
        } catch (\Throwable $e) {
            $updater->rollBack();
            throw $e;
        }

        return self::SUCCESS;
    }
}
