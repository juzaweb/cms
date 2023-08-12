<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\DevTool\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CacheSizeCommand extends Command
{
    protected $name = 'cache:size';

    public function handle(): void
    {
        $fileSize = 0;
        foreach (File::allFiles(storage_path('framework/cache')) as $file) {
            $fileSize += $file->getSize();
        }

        $this->info("Current cache site: " . format_size_units($fileSize));
    }
}
