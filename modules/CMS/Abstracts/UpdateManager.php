<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Abstracts;

use GuzzleHttp\Psr7\Utils;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\JuzawebApiContract;
use Juzaweb\CMS\Support\Curl;

/**
 * @method void beforeFinish()
 * @method void afterFinish()
 * @method void afterUpdateFileAndFolder()
*/
abstract class UpdateManager
{
    protected Curl $curl;
    protected JuzawebApiContract $api;
    protected FilesystemAdapter $storage;
    protected array $updatePaths = [];
    protected int $maxStep = 6;

    public function __construct(Curl $curl, JuzawebApiContract $api)
    {
        $this->curl = $curl;
        $this->api = $api;
        $this->storage = Storage::disk('tmp');
    }

    abstract public function getVersionAvailable(): string;

    abstract public function getCurrentVersion(): string;

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
        for ($i=1; $i<=$this->maxStep; $i++) {
            $this->updateByStep($i);
        }

        return true;
    }

    public function updateByStep(int $step): bool
    {
        switch ($step) {
            case 1:
                $this->fetchDataUpdate();
                break;
            case 2:
                $this->downloadUpdateFile();
                break;
            case 3:
                $this->unzipFile();
                break;
            case 4:
                $this->backupOldVersion();
                break;
            case 5:
                $this->updateFileAndFolder();
                break;
            case 6:
                $this->finish();
        }

        return true;
    }

    public function fetchDataUpdate(): void
    {
        $this->setCacheData('response', $this->fetchData());
    }

    public function downloadUpdateFile(): bool
    {
        $this->setProcess('downloading');

        $tmpFolder = Str::lower(Str::random(10));
        $this->setCacheData('tmpFolder', $tmpFolder);

        foreach (['zip', 'unzip', 'backup'] as $folder) {
            if (!$this->storage->exists("{$tmpFolder}/{$folder}")) {
                File::makeDirectory(
                    $this->storage->path("{$tmpFolder}/{$folder}"),
                    0775,
                    true
                );
            }
        }

        $tmpFile = $tmpFolder.'/zip/'. Str::lower(Str::random(5)).'.zip';
        $tmpFilePath = $this->storage->path($tmpFile);

        if (!$this->downloadFile($this->getCacheData('response')->data->link, $tmpFilePath)) {
            return false;
        }

        $this->setCacheData('tmpFile', $tmpFile);
        $this->setCacheData('tmpFilePath', $tmpFilePath);

        $this->setProcess('downloaded');
        return true;
    }

    public function unzipFile(): bool
    {
        $this->setProcess('unzip');
        $zip = new \ZipArchive();
        $op = $zip->open($this->getCacheData('tmpFilePath'));

        if ($op !== true) {
            return false;
        }

        $zip->extractTo($this->storage->path("{$this->getCacheData('tmpFolder')}/unzip"));
        $zip->close();
        $this->setProcess('unzip_success');
        return true;
    }

    public function backupOldVersion(): void
    {
        $this->setProcess('backup');

        $localFolder = $this->getBackupPath();

        $tmpFolder = $this->storage->path($this->getCacheData('tmpFolder'));

        if (!is_dir($localFolder)) {
            File::makeDirectory($localFolder, 0775, true);
        }

        $this->updateFolder($localFolder, "{$tmpFolder}/backup");

        $this->setProcess('backup_done');
    }

    public function updateFileAndFolder(): void
    {
        $this->setProcess('updating');

        $localFolder = $this->getLocalPath();

        $tmpFolder = $this->storage->path($this->getCacheData('tmpFolder'));

        $zipFolders = File::directories("{$tmpFolder}/unzip");

        foreach ($zipFolders as $folder) {
            $this->updateFolder($folder, $localFolder);
            break;
        }

        if (method_exists($this, 'afterUpdateFileAndFolder')) {
            $this->afterUpdateFileAndFolder();
        }

        $this->setProcess('updated');
    }

    public function finish(): void
    {
        $this->setProcess('before_finish');
        if (method_exists($this, 'beforeFinish')) {
            $this->beforeFinish();
        }

        $tmpFolder = $this->getCacheData('tmpFolder');
        File::deleteDirectory($this->storage->path($tmpFolder), true);
        File::deleteDirectory($this->storage->path($tmpFolder));

        Artisan::call('optimize:clear');

        if (method_exists($this, 'afterFinish')) {
            $this->afterFinish();
        }

        Cache::store('file')->pull($this->getCacheKey());
    }

    public function rollBack(): void
    {
        //
    }

    public function getUploadPaths(): array
    {
        return $this->updatePaths;
    }

    public function getMaxStep(): int
    {
        return $this->maxStep;
    }

    protected function updateFolder(string $source, string $target): bool
    {
        $updatePaths = $this->getUploadPaths();
        if (empty($updatePaths)) {
            File::copyDirectory($source, $target);
            return true;
        }

        foreach ($updatePaths as $path) {
            $sourcePath = str_replace('\\', '/', "{$source}/{$path}");
            $targetPath = str_replace('\\', '/', "{$target}/{$path}");

            if (is_dir($sourcePath)) {
                File::copyDirectory(
                    $sourcePath,
                    $targetPath
                );
            }

            if (is_file($sourcePath)) {
                if (!File::isDirectory(dirname($targetPath))) {
                    File::makeDirectory(dirname($targetPath), 0775, true);
                }

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
        $this->setCacheData('process', $process);
    }

    protected function setCacheData(string $key, mixed $value): void
    {
        $data = Cache::store('file')->get($this->getCacheKey());
        $data[$key] = $value;
        Cache::store('file')->set($this->getCacheKey(), $data, 3600);
    }

    protected function getCacheData(string $key = null): mixed
    {
        $data = Cache::store('file')->get($this->getCacheKey());
        return $data[$key] ?? null;
    }

    protected function responseErrors(object $response): void
    {
        if (isset($response->errors) && is_array($response->errors)) {
            throw new \Exception($response->errors[0]->message);
        }
    }

    protected function getBackupPath(): string
    {
        return $this->getLocalPath();
    }

    abstract protected function getLocalPath(): string;

    abstract protected function getCacheKey(): string;

    abstract protected function fetchData(): object;
}
