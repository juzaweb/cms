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

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $maxSlot
 */
trait CommandSlot
{
    protected function getCurrentSlot(string $key = null): bool|int
    {
        $key = $this->getSlotKey($key);

        if (config('app.debug')) {
            $slot = 1;
        } else {
            $data = $this->readCommandSlotData($key);

            if ($data) {
                $slot = $this->getIdleSlotFromData($data);

                if (empty($slot)) {
                    return false;
                }
            } else {
                $slot = 1;
            }
        }

        $data[$slot] = [
            'slot' => $slot,
            'command' => $this->signature,
            'date' => date('Y-m-d H:i:s')
        ];

        $this->writeCommandSlotData($key, $data);

        if ($slot > $this->maxSlot) {
            return false;
        }

        return $slot;
    }

    protected function removeSlot(int $slot, string $key = null): bool
    {
        $key = $this->getSlotKey($key);

        $data = $this->readCommandSlotData($key);

        unset($data[$slot]);

        return $this->writeCommandSlotData($key, $data);
    }

    protected function updateSlot(int $slot, string $date, string $key = null): bool
    {
        $key = $this->getSlotKey($key);

        $data = $this->readCommandSlotData($key);

        $data[$slot]['date'] = $date;

        return $this->writeCommandSlotData($key, $data);
    }

    private function getIdleSlotFromData(array $data): int
    {
        $slots = range(1, $this->maxSlot);

        $slots = array_values(array_diff($slots, array_keys($data)));

        return $slots[0] ?? 0;
    }

    private function writeCommandSlotData(string $key, array $data): bool
    {
        $path = $this->getPathFileData($key);

        return (bool) $this->getStorage()->put($path, json_encode($data));
    }

    private function readCommandSlotData(string $key): array
    {
        $path = $this->getPathFileData($key);

        $storage = $this->getStorage();

        if ($storage->exists($path)) {
            return json_decode(
                $storage->get($path),
                true
            );
        }

        return [];
    }

    private function getPathFileData($key): string
    {
        $fileName = $this->generateFileName($key);

        return "command-slots/{$fileName}";
    }

    private function getSlotKey(string $key = null): string
    {
        return $key ?? $this->signature;
    }

    private function generateFileName(string $key): string
    {
        return md5($key).'.json';
    }

    private function getStorage(): FilesystemAdapter
    {
        return Storage::disk('local');
    }
}
