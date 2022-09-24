<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

trait CommandData
{
    protected function getCommandData(
        string $key = null,
        mixed $default = null
    ): mixed {
        $path = "command-datas/". $this->getKeyCommandData() .".json";

        if (Storage::disk('local')->exists($path)) {
            $data = json_decode(Storage::disk('local')->get($path), true);
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
        $path = "command-datas/". md5($this->signature) .".json";
        if (is_array($key)) {
            return (bool) Storage::disk('local')->put(
                $path,
                json_encode($key)
            );
        }

        $data = $this->getCommandData();
        $data[$key] = $value;

        return (bool) Storage::disk('local')->put(
            $path,
            json_encode($data)
        );
    }

    protected function getKeyCommandData()
    {
        if ($this->getName()) {
            return md5($this->getName());
        }

        return md5($this->signature);
    }
}
