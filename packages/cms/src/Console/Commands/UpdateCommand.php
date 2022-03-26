<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Console\Commands;

use Codedge\Updater\UpdaterManager;
use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    protected $signature = 'juzacms:update';

    public function handle(UpdaterManager $updater)
    {
        /*$update = new UpdateManager();

        $this->info('Check file update');
        $update->updateStep1();

        $this->info('Download File');
        $update->updateStep2();

        $this->info('Unzip File');
        $update->updateStep3();

        $this->info('Move to folder');
        $update->updateStep4();

        $this->info('Update database');
        $update->updateStep5();*/
    
        $currentVersion = $updater->source()->getVersionInstalled();
        $versionAvailable = $updater->source()->getVersionAvailable();
    
        $this->info("Current installed version: {$currentVersion}");
        $this->info("Version available: {$versionAvailable}");
        
        if($updater->source()->isNewVersionAvailable()) {
            $release = $updater->source()->fetch($versionAvailable);
    
            // Run the update process
            $update = $updater->source()->update($release);
    
            if ($update) {
                $this->info('Update successful.');
            } else {
                $this->error('Update fail. Please check folder permissions');
            }
        } else {
            $this->info('No new version available.');
        }
    
        return self::SUCCESS;
    }
}
