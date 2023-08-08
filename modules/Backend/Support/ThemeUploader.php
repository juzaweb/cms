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
use Juzaweb\CMS\Facades\Theme;

class ThemeUploader
{
    protected UploadedFile $file;

    protected string $tmpFolder;

    protected string $tmpRootFolder;

    protected array $themeInfo;

    public function upload(UploadedFile $file): array
    {
        $this->file = $file;

        $this->uploadFileValidate();

        $this->makeTmpFolder();

        $this->unzipFile();

        $this->findRootFolder();

        $this->validateTheme();

        $this->copyToFolder();

        $this->removeTempFiles();

        return $this->themeInfo;
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
        File::moveDirectory(
            $this->tmpRootFolder,
            config('juzaweb.theme.path') . '/' . $this->themeInfo['name']
        );

        return true;
    }

    protected function validateTheme(): bool
    {
        $theme = json_decode(
            File::get("{$this->tmpRootFolder}/theme.json"),
            true
        );

        $validator = Validator::make(
            $theme,
            [
                'name' => 'bail|required|max:100',
                'title' => 'bail|required|max:100',
                'version' => 'bail|required|max:50',
            ]
        );

        if ($validator->fails()) {
            $this->throwError(array_values($validator->errors()->messages())[0][0]);
        }

        if (Theme::find($theme['name']) || is_dir(theme_path($theme['name']))) {
            $this->throwError(
                trans(
                    'cms::app.theme_upload.error.exists',
                    ['name' => $theme['name']]
                )
            );
        }

        $this->themeInfo = $theme;

        return true;
    }

    protected function uploadFileValidate(): bool
    {
        if ($this->file->getMimeType() != 'application/zip') {
            $this->throwError(trans('cms::app.theme_upload.error.mime_type'));
        }

        if ($this->file->extension() != 'zip') {
            $this->throwError(trans('cms::app.theme_upload.error.extension'));
        }

        return true;
    }

    protected function findRootFolder(): bool
    {
        if (File::exists("{$this->tmpFolder}/theme.json")) {
            $this->tmpRootFolder = $this->tmpFolder;
            return true;
        }

        $directories = File::directories($this->tmpFolder);

        foreach ($directories as $dir) {
            if (File::exists("{$dir}/theme.json")) {
                $this->tmpRootFolder = $dir;
                return true;
            }
        }

        $this->throwError(
            trans(
                'cms::app.theme_upload.error.file_required',
                ['name' => 'theme.json']
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

        $this->throwError(trans('cms::app.theme_upload.error.unzip'));
    }

    protected function makeTmpFolder(): void
    {
        $folder = 'theme-' . Str::random(5);

        $this->tmpFolder = Storage::disk('tmp')->path($folder);

        if (!is_dir($this->tmpFolder)) {
            File::makeDirectory($this->tmpFolder, 0777, true);
        }
    }

    protected function throwError(string $message): void
    {
        $this->removeTempFiles();

        throw new \Exception($message);
    }
}
