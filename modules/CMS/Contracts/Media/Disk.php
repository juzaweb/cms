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

    public function get(string $path): string;

    public function getName(): string;

    public function filesystem(): Filesystem;

    public function upload(string $path, string $name, array $options = []): FileInterface;

    public function put(string $path, string $contents, array $options = []): FileInterface;

    public function deleteFile(string $path): bool;

    public function fileExists(string $path): bool;

    public function findFolder(string $path): ?FolderInterface;

    public function findFolderOrFail(string $path): FolderInterface;

    /**
     * @param  string  $path
     * @return null|FileInterface
     */
    public function findFile(string $path): ?FileInterface;

    public function findFileOrFail(string $path): FileInterface;

    public function setFileSystem(Filesystem $filesystem): static;
}
