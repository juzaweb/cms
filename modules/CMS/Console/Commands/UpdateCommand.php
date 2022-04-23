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

        try {
            $updater->update();
        } catch (\Exception $e) {
            $updater->rollBack();
            throw $e;
        }

        return self::SUCCESS;
    }
}
