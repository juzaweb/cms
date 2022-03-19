<?php

namespace Juzaweb\Support\FileManager;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileManager
{
    public const PACKAGE_NAME = 'filemanager';
    public const DS = '/';

    protected $config;
    protected $request;

    public function __construct(Config $config = null, Request $request = null)
    {
        $this->config = $config;
        $this->request = $request;
    }

    public function getStorage($storage_path)
    {
        return new LfmStorageRepository($storage_path, $this);
    }

    public function input($key)
    {
        return $this->translateFromUtf8($this->request->input($key));
    }

    public function config($key)
    {
        return $this->config->get('filemanager.' . $key);
    }

    /**
     * Get only the file name.
     *
     * @param  string  $path  Real path of a file.
     * @return string
     */
    public function getNameFromPath($path)
    {
        return pathinfo($path, PATHINFO_BASENAME);
    }

    public function getCategoryName()
    {
        $type = $this->currentLfmType();

        return $this->config->get('lfm.folder_categories.' . $type . '.folder_name', 'files');
    }

    /**
     * Get current lfm type.
     *
     * @return string
     */
    public function currentLfmType()
    {
        $lfm_type = 'file';

        $request_type = lcfirst(Str::singular($this->input('type') ?: ''));
        $available_types = array_keys($this->config->get('lfm.folder_categories') ?: []);

        if (in_array($request_type, $available_types)) {
            $lfm_type = $request_type;
        }

        return $lfm_type;
    }

    public function getDisplayMode()
    {
        $type_key = $this->currentLfmType();
        $startup_view = $this->config->get('lfm.folder_categories.' . $type_key . '.startup_view');

        $view_type = 'grid';
        $target_display_type = $this->input('show_list') ?: $startup_view;

        if (in_array($target_display_type, ['list', 'grid'])) {
            $view_type = $target_display_type;
        }

        return $view_type;
    }

    public function getUserSlug()
    {
        $config = $this->config->get('lfm.private_folder_name');

        if (is_callable($config)) {
            return call_user_func($config);
        }

        if (class_exists($config)) {
            return app()->make($config)->userField();
        }

        return empty(auth()->user()) ? '' : auth()->user()->$config;
    }

    public function getRootFolder($type = null)
    {
        if (is_null($type)) {
            $type = 'share';
            if ($this->allowFolderType('user')) {
                $type = 'user';
            }
        }

        if ($type === 'user') {
            $folder = $this->getUserSlug();
        } else {
            $folder = $this->config->get('lfm.shared_folder_name');
        }

        // the slash is for url, dont replace it with directory seperator
        return '/' . $folder;
    }

    public function getThumbFolderName()
    {
        return $this->config->get('lfm.thumb_folder_name');
    }

    public function getFileType($ext)
    {
        return $this->config->get("lfm.file_type_array.{$ext}", 'File');
    }

    public function availableMimeTypes()
    {
        return $this->config->get('lfm.folder_categories.' . $this->currentLfmType() . '.valid_mime');
    }

    public function maxUploadSize()
    {
        return $this->config->get('lfm.folder_categories.' . $this->currentLfmType() . '.max_size');
    }

    public function getPaginationPerPage()
    {
        return $this->config->get("lfm.paginator.perPage", 30);
    }

    /**
     * Check if users are allowed to use their private folders.
     *
     * @return bool
     */
    public function allowMultiUser()
    {
        return $this->config->get('lfm.allow_private_folder') === true;
    }

    /**
     * Check if users are allowed to use the shared folder.
     * This can be disabled only when allowMultiUser() is true.
     *
     * @return bool
     */
    public function allowShareFolder()
    {
        if (! $this->allowMultiUser()) {
            return true;
        }

        return $this->config->get('lfm.allow_shared_folder') === true;
    }

    /**
     * Translate file name to make it compatible on Windows.
     *
     * @param  string  $input  Any string.
     * @return string
     */
    public function translateFromUtf8($input)
    {
        if ($this->isRunningOnWindows()) {
            $input = iconv('UTF-8', mb_detect_encoding($input), $input);
        }

        return $input;
    }

    /**
     * Get directory seperator of current operating system.
     *
     * @return string
     */
    public function ds()
    {
        $ds = FileManager::DS;
        if ($this->isRunningOnWindows()) {
            $ds = '\\';
        }

        return $ds;
    }

    /**
     * Check current operating system is Windows or not.
     *
     * @return bool
     */
    public function isRunningOnWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Shorter function of getting localized error message.
     *
     * @param  mixed $error_type Key of message in lang file.
     * @param  mixed $variables Variables the message needs.
     * @return string
     * @throws \Exception
     */
    public function error($error_type, $variables = [])
    {
        throw new \Exception(trans(self::PACKAGE_NAME . '::lfm.error-' . $error_type, $variables));
    }
}
