<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Juzaweb\CMS\Facades\Plugin;

class PluginUploader
{
    protected UploadedFile $file;

    protected string $tmpFolder;

    protected string $tmpRootFolder;

    protected array $info;

    public function upload(UploadedFile $file): array
    {
        $this->file = $file;

        $this->uploadFileValidate();

        $this->makeTmpFolder();

        $this->unzipFile();

        $this->findRootFolder();

        $this->validateInfo();

        $this->copyToFolder();

        $this->removeTempFiles();

        return $this->info;
    }

    public function removeTempFiles(): bool
    {
        if ($this->tmpFolder && is_dir($this->tmpFolder)) {
            File::deleteDirectory($this->tmpFolder);
        }

        File::delete($this->file->getRealPath());

        return true;
    }

    protected function copyToFolder(): bool
    {
        return File::moveDirectory(
            $this->tmpRootFolder,
            config('juzaweb.plugin.path') . '/' . $this->getLocalFolder()
        );
    }

    protected function validateInfo(): bool
    {
        $this->info = json_decode(
            File::get("{$this->tmpRootFolder}/{$this->getIndexFile()}"),
            true
        );

        $validator = Validator::make(
            $this->info,
            [
                'name' => 'bail|required|max:100',
                'extra.juzaweb.name' => 'bail|required|max:100',
                'extra.juzaweb.version' => 'bail|required|max:50',
                'extra.juzaweb.domain' => 'bail|required|max:50',
            ]
        );

        if ($validator->fails()) {
            $this->throwError(array_values($validator->errors()->messages())[0][0]);
        }

        if (Plugin::find($this->info['name']) || is_dir(config('juzaweb.plugin.path').'/'.$this->getLocalFolder())) {
            $this->throwError(
                trans(
                    'cms::app.plugin_upload.error.exists',
                    ['name' => $this->info['name']]
                )
            );
        }

        return true;
    }

    protected function uploadFileValidate(): bool
    {
        if ($this->file->getMimeType() != 'application/zip') {
            $this->throwError(trans('cms::app.plugin_upload.error.mime_type'));
        }

        if ($this->file->extension() != 'zip') {
            $this->throwError(trans('cms::app.plugin_upload.error.extension'));
        }

        return true;
    }

    protected function findRootFolder(): bool
    {
        if (File::exists("{$this->tmpFolder}/{$this->getIndexFile()}")) {
            $this->tmpRootFolder = $this->tmpFolder;
            return true;
        }

        $directories = File::directories($this->tmpFolder);

        foreach ($directories as $dir) {
            if (File::exists("{$dir}/{$this->getIndexFile()}")) {
                $this->tmpRootFolder = $dir;
                return true;
            }
        }

        $this->throwError(
            trans(
                'cms::app.plugin_upload.error.file_required',
                ['name' => $this->getIndexFile()]
            )
        );
    }

    protected function unzipFile(): bool
    {
        $zip = new \ZipArchive();
        if ($zip->open($this->file->getRealPath()) === true) {
            $zip->extractTo($this->tmpFolder);
            $zip->close();
            return true;
        }

        $this->throwError(trans('cms::app.plugin_upload.error.unzip'));
    }

    protected function makeTmpFolder(): void
    {
        $folder = 'plugin-' . Str::random(5);

        $this->tmpFolder = Storage::disk('tmp')->path($folder);

        if (!is_dir($this->tmpFolder)) {
            File::makeDirectory($this->tmpFolder, 0777, true);
        }
    }

    protected function getLocalFolder(): string
    {
        return explode('/', $this->info['name'])[1];
    }

    protected function getIndexFile(): string
    {
        return 'composer.json';
    }

    protected function throwError(string $message): void
    {
        $this->removeTempFiles();

        throw new \Exception($message);
    }
}
