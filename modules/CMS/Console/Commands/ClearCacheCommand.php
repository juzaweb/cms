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
use Illuminate\Support\Facades\Cache;

class ClearCacheCommand extends Command
{
    protected $signature = 'juzacms:cache-clear';

    public function handle(): int
    {
        if (config('cache.default') != 'file') {
            Cache::clear();
        }

        Cache::store('file')->clear();

        return self::SUCCESS;
    }
}
