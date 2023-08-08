<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AutoClearSlotCommand extends Command
{
    protected $signature = 'juzacms:clear-command-slots';

    protected $description = 'Auto clear command slots.';

    protected int $limitSeconds = 7200; // 1 day

    public function handle(): int
    {
        $storage = Storage::disk('local');

        if (!File::isDirectory($storage->path('command-slots'))) {
            return self::SUCCESS;
        }

        $files = File::files($storage->path('command-slots'));

        foreach ($files as $file) {
            $path = 'command-slots/'. $file->getBasename();

            $data = collect(json_decode($file->getContents(), true))
                ->filter(
                    function ($item) {
                        $plus1Day = date('Y-m-d H:i:s', strtotime($item['date']. " + {$this->limitSeconds} seconds"));
                        return $plus1Day > date('Y-m-d H:i:s');
                    }
                )
                ->toArray();

            if (empty($data)) {
                $storage->delete($path);
            } else {
                $storage->put($path, json_encode($data));
            }

            $this->info("Updated file {$path}");
        }

        return self::SUCCESS;
    }
}
