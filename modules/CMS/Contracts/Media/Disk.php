<?php

namespace Juzaweb\CMS\Contracts\Media;

use Illuminate\Contracts\Filesystem\Filesystem;
use Juzaweb\CMS\Interfaces\Media\FileInterface;
use Juzaweb\CMS\Interfaces\Media\FolderInterface;

/**
 * @see \Juzaweb\CMS\Support\Media\Disk
 */
interface Disk
{
    public function path(string $path): string;

    public function fullPath(string $path): string;

    public function getName(): string;

    public function filesystem(): Filesystem;

    public function upload(string $source, string $name): FileInterface;

    public function deleteFile(string $path): bool;

    public function downloadUrl(string $path, int $livetime = 3600): string;

    public function fileExists(string $path): bool;

    public function findFolder(string $path): ?FolderInterface;

    /**
     * @param  string  $path
     * @return null|FileInterface
     */
    public function findFile(string $path): ?FileInterface;
}
