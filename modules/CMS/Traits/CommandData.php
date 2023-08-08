<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

trait CommandData
{
    protected Filesystem $disk;

    protected function getCommandData(
        string $key = null,
        mixed $default = null
    ): mixed {
        $path = $this->getCommandDataPath();

        if ($this->storageDisk()->exists($path)) {
            $data = json_decode($this->storageDisk()->get($path), true);
            if ($key) {
                return Arr::get($data, $key, $default);
            }

            return $data;
        }

        if ($key) {
            return $default;
        }

        return [];
    }

    protected function setCommandData(array|string $key, mixed $value = null): bool
    {
        $path = $this->getCommandDataPath();
        if (is_array($key)) {
            return $this->storageDisk()->put(
                $path,
                json_encode($key)
            );
        }

        $data = $this->getCommandData();
        $data[$key] = $value;

        return $this->storageDisk()->put(
            $path,
            json_encode($data)
        );
    }

    protected function getCommandDataKey(): string
    {
        if ($this->getName()) {
            return md5($this->getName());
        }

        return md5($this->signature);
    }

    protected function getCommandDataPath(): string
    {
        return "command-datas/". $this->getCommandDataKey() .".json";
    }

    protected function storageDisk(): Filesystem
    {
        if (isset($this->disk)) {
            return $this->disk;
        }

        return $this->disk = Storage::disk('local');
    }
}
