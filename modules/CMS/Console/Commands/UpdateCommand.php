<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
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
            $updater->fetchDataUpdate();
            $this->info('-- Download update file');
            $updater->downloadUpdateFile();
            $this->info('-- Unzip file');
            $updater->unzipFile();
            $this->info('-- Backup old version');
            $updater->backupOldVersion();
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
