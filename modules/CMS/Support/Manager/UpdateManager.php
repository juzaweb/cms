<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Manager;

use GuzzleHttp\Psr7\Utils;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Juzaweb\CMS\Support\Curl;
use Juzaweb\CMS\Support\JuzawebApi;

abstract class UpdateManager
{
    protected Curl $curl;
    protected JuzawebApi $api;
    protected FilesystemAdapter $storage;
    protected object $response;
    protected string $tmpFolder;
    protected string $tmpFile;
    protected string $tmpFilePath;
    protected string $process;
    protected array $updatePaths = [];

    public function __construct(Curl $curl, JuzawebApi $api)
    {
        $this->curl = $curl;
        $this->api = $api;
        $this->storage = Storage::disk('tmp');
    }

    public function checkForUpdate(): bool
    {
        return version_compare(
            $this->getVersionAvailable(),
            $this->getCurrentVersion(),
            '>'
        );
    }

    public function update(): bool
    {
        $this->fetchData();
        $this->downloadUpdateFile();
        $this->unzipFile();
        $this->updateFileAndFolder();
        $this->finish();
        return true;
    }

    public function downloadUpdateFile(): bool
    {
        $this->setProcess('downloading');

        $this->tmpFolder = Str::lower(Str::random(10));
        foreach (['zip', 'unzip', 'backup'] as $folder) {
            if (!$this->storage->exists("{$this->tmpFolder}/{$folder}")) {
                File::makeDirectory(
                    $this->storage->path("{$this->tmpFolder}/{$folder}"),
                    0775,
                    true
                );
            }
        }

        $this->tmpFile = $this->tmpFolder.'/zip/'. Str::lower(Str::random(5)).'.zip';
        $this->tmpFilePath = $this->storage->path($this->tmpFile);

        if (!$this->downloadFile($this->response->data->link, $this->tmpFilePath)) {
            return false;
        }

        $this->setProcess('downloaded');
        return true;
    }

    public function unzipFile(): bool
    {
        $this->setProcess('unzip');
        $zip = new \ZipArchive();
        $op = $zip->open($this->tmpFilePath);

        if ($op !== true) {
            return false;
        }

        $zip->extractTo($this->storage->path("{$this->tmpFolder}/unzip"));
        $zip->close();
        $this->setProcess('unzip_success');
        return true;
    }

    public function updateFileAndFolder(): void
    {
        $this->setProcess('updating');
        $localFolder = $this->getLocalPath();
        $tmpFolder = $this->storage->path($this->tmpFolder);

        if (!is_dir($localFolder)) {
            File::makeDirectory($localFolder, 0775, true);
        }

        $this->setProcess('backup');
        $zipFolders = File::directories("{$tmpFolder}/unzip");

        $this->updateFolder($localFolder, "{$tmpFolder}/backup");

        $this->setProcess('move_folder');
        foreach ($zipFolders as $folder) {
            $this->updateFolder($folder, $localFolder);
            break;
        }
    }

    public function finish(): void
    {
        $this->setProcess('before_finish');
        if (method_exists($this, 'beforeFinish')) {
            $this->beforeFinish();
        }

        File::deleteDirectory($this->storage->path($this->tmpFolder), true);
        File::deleteDirectory($this->storage->path($this->tmpFolder));

        Artisan::call('optimize:clear');

        if (method_exists($this, 'afterFinish')) {
            $this->afterFinish();
        }
    }

    public function rollBack(): void
    {
        //
    }

    protected function updateFolder(string $source, string $target): bool
    {
        if (empty($this->updatePaths)) {
            File::copyDirectory($source, $target);
            return true;
        }

        foreach ($this->updatePaths as $path) {
            $sourcePath = str_replace('\\', '/', "{$source}/{$path}");
            $targetPath = str_replace('\\', '/', "{$target}/{$path}");

            if (is_dir($sourcePath)) {
                File::copyDirectory(
                    $sourcePath,
                    $targetPath
                );
            }

            if (is_file($sourcePath)) {
                File::copy($sourcePath, $targetPath);
            }
        }

        return true;
    }

    protected function downloadFile($url, $filename): ?string
    {
        $resource = Utils::tryFopen($filename, 'w');

        $this->curl->getClient()->request(
            'GET',
            $url,
            [
                'curl' => [
                    CURLOPT_TCP_KEEPALIVE => 10,
                    CURLOPT_TCP_KEEPIDLE => 10,
                ],
                'sink' => $resource,
            ]
        );

        return $filename;
    }

    protected function setProcess(string $process): void
    {
        $this->process = $process;
    }

    protected function responseErrors(object $response): void
    {
        if (isset($response->errors) && is_array($response->errors)) {
            throw new \Exception($response->errors[0]->message);
        }
    }

    abstract protected function getLocalPath(): string;
}
