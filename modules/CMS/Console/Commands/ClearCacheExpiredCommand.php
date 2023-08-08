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
use Illuminate\Support\Facades\Storage;

class ClearCacheExpiredCommand extends Command
{
    protected $signature = 'juzacms:clear-cache-expired';
    protected $description = 'Remove all expired cache files and folders';

    private int $expiredFileCount = 0;
    private int $expiredFileSize = 0;
    private int $activeFileCount = 0;
    private int $activeFileSize = 0;

    public function __construct()
    {
        parent::__construct();

        $cacheDisk = [
            'driver' => 'local',
            'root' => config('cache.stores.file.path'),
        ];

        config(['filesystems.disks.fcache' => $cacheDisk]);
    }

    public function handle(): void
    {
        $this->deleteExpiredFiles();
        $this->deleteEmptyFolders();
        $this->showResults();
    }

    private function deleteExpiredFiles(): void
    {
        $files = Storage::disk('fcache')->allFiles();
        $this->output->progressStart(count($files));

        // Loop the files and get rid of any that have expired
        foreach ($files as $cachefile) {
            // Ignore files that named with dot(.) at the begining e.g. .gitignore
            if (str_starts_with($cachefile, '.')) {
                continue;
            }

            // Grab the contents of the file
            $contents = Storage::disk('fcache')->get($cachefile);

            // Get the expiration time
            $expire = substr($contents, 0, 10);

            // See if we have expired
            try {
                if (time() >= $expire) {
                    // Delete the file
                    $this->expiredFileSize += Storage::disk('fcache')->size($cachefile);
                    Storage::disk('fcache')->delete($cachefile);
                    $this->expiredFileCount++;
                } else {
                    $this->activeFileCount++;
                    $this->activeFileSize += Storage::disk('fcache')->size($cachefile);
                }
            }  catch (\Throwable $e) {
                // File is deleted
            }

            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }

    private function deleteEmptyFolders(): void
    {
        $directories = Storage::disk('fcache')->allDirectories();
        $dirCount = count($directories);
        // looping backward to make sure subdirectories are deleted first
        while (--$dirCount >= 0) {
            if (!Storage::disk('fcache')->allFiles($directories[$dirCount])) {
                Storage::disk('fcache')->deleteDirectory($directories[$dirCount]);
            }
        }
    }

    public function showResults(): void
    {
        $expiredFileSize = $this->formatBytes($this->expiredFileSize);
        $activeFileSize = $this->formatBytes($this->activeFileSize);

        if ($this->expiredFileCount) {
            $this->info("✔ {$this->expiredFileCount} expired cache files removed");
            $this->info("✔ {$expiredFileSize} disk cleared");
        } else {
            $this->info('✔ No expired cache file found!');
        }

        $this->line("✔ {$this->activeFileCount} non-expired cache files remaining");
        $this->line("✔ {$activeFileSize} disk space taken by non-expired cache files");
    }

    private function formatBytes($size): string
    {
        $unit = ['Byte','KB','MB','GB','TB','PB','EB','ZB','YB'];

        for ($i = 0; $size >= 1024 && $i < count($unit)-1; $i++) {
            $size /= 1024;
        }

        return round($size, 2).' '.$unit[$i];
    }
}
