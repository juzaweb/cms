<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Console\Commands;

use Illuminate\Console\Command;
use Juzaweb\Support\Manager\UpdateManager;

class UpdateCommand extends Command
{
    protected $signature = 'juzaweb:update';

    public function handle()
    {
        $update = new UpdateManager();

        $this->info('Check file update');
        $update->updateStep1();

        $this->info('Download File');
        $update->updateStep2();

        $this->info('Unzip File');
        $update->updateStep3();

        $this->info('Move to folder');
        $update->updateStep4();

        $this->info('Update database');
        $update->updateStep5();
    }
}
