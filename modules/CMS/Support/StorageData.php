<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\StorageDataContract;

class StorageData implements StorageDataContract
{
    protected int $fileRowLimit = 1200;

    protected FilesystemAdapter $storage;

    public function push(string $table, array $data): bool
    {
        $tableData = $this->getTableData($table);

        $fileData = $this->getFileData($table, $tableData['files']);

        $data = collect($data)->values()->mapWithKeys(
            function ($item) {
                $key = Str::uuid()->toString();
                $item['id'] = $key;
                return [$key => $item];
            }
        )
        ->toArray();

        $items = collect(array_merge($data, $fileData))
            ->chunk($this->fileRowLimit);

        $i = $tableData['files'];
        foreach ($items as $item) {
            $this->putFileData($table, $i, $item->toArray());
            $i++;
        }

        $i--;

        $tableData['files'] = $i;

        return $this->putTableData($table, $tableData);
    }

    public function files(string $table): \RecursiveIteratorIterator
    {
        $path = $this->getStorage()->path($this->getTablePath($table));

        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
    }

    public function countFile(string $table): int
    {
        $files = $this->files($table);

        return iterator_count($files);
    }

    public function putFileData(string $table, string $key, array $data): bool
    {
        $path = $this->getKeyPath($table, $key);

        return $this->getStorage()->put($path, json_encode($data));
    }

    public function getFileData(string $table, string $key): array
    {
        $path = $this->getKeyPath($table, $key);

        if ($this->getStorage()->exists($path)) {
            $data = json_decode(
                $this->getStorage()->get($path),
                true
            );

            if (is_null($data)) {
                return [];
            }

            return $data;
        }

        return [];
    }

    public function putTableData(string $table, array $data): bool
    {
        $path = $this->getTableDataPath($table);

        return $this->getStorage()->put($path, json_encode($data));
    }

    public function getTableData(string $table): array
    {
        $tablePath = $this->getTableDataPath($table);

        if ($this->getStorage()->exists($tablePath)) {
            return json_decode(
                $this->getStorage()->get($tablePath),
                true
            );
        }

        return $this->getTableDefaultData($table);
    }

    public function setFileRowLimit(int $limit): void
    {
        $this->fileRowLimit = $limit;
    }

    public function getFileRowLimit(): int
    {
        return $this->fileRowLimit;
    }

    protected function getTableDefaultData(string $table): array
    {
        return [
            'table' => $table,
            'rows' => 0,
            'files' => 1,
        ];
    }

    protected function getKeyPath(string $table, string $key): string
    {
        return "json-datas/{$table}/{$key}.json";
    }

    protected function getTablePath(string $table): string
    {
        return "json-datas/{$table}";
    }

    protected function getTableDataPath(string $table): string
    {
        return "json-datas/{$table}.json";
    }

    protected function getStorage(): FilesystemAdapter
    {
        if (!isset($this->storage)) {
            $this->storage = Storage::disk('local');
        }

        return $this->storage;
    }
}
