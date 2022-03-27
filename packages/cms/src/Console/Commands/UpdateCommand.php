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
        $currentVersion = $updater->source()->getVersionInstalled();
        $versionAvailable = $updater->source()->getVersionAvailable();
    
        $this->info("Current installed version: {$currentVersion}");
        $this->info("Version available: {$versionAvailable}");
        
        if($updater->source()->isNewVersionAvailable()) {
            $release = $updater->source()->fetch($versionAvailable);
    
            // Run the update process
            $update = $updater->source()->update($release);
    
            if ($update) {
                $this->callCommands();
                
                $this->info('Update successful.');
            } else {
                $this->error('Update fail. Please check folder permissions');
            }
        } else {
            $this->info('No new version available.');
        }
        
        return self::SUCCESS;
    }
    
    protected function callCommands()
    {
        $basePath = base_path();
        shell_exec(PHP_BINARY . " {$basePath}/composer.phar install");
    
        $this->call('migrate');
        $this->call('optimize:clear');
        $this->call(
            'vendor:publish',
            [
                '--tag' => 'cms_assets',
                '--force' => true,
            ]
        );
    
        $theme = jw_current_theme();
        $this->call(
            'theme:publish',
            [
                'theme' => $theme,
                'type' => 'assets',
            ]
        );
    }
}
