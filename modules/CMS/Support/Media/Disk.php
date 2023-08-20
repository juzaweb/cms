<?php

namespace Juzaweb\CMS\Support\Media;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Juzaweb\CMS\Contracts\Media\Disk as DiskContract;
use Juzaweb\CMS\Interfaces\Media\FileInterface;
use Juzaweb\CMS\Interfaces\Media\FolderInterface;

class Disk implements DiskContract
{
    protected string $name;
    protected Factory $filesystemFactory;
    protected Filesystem $filesystem;

    public function __construct(string $name, $filesystemFactory)
    {
        $this->name = $name;
        $this->filesystemFactory = $filesystemFactory;
    }

    public function upload(string $source, string $name): FileInterface
    {
        $this->uploadWithoutSaveDatabase($source, $name);

        $this->filesystem()->put($source, $name);

        return $this->createFile($name);
    }

    public function uploadWithoutSaveDatabase(string $source, string $name): FileInterface
    {
        $resource = fopen($source, 'rb+');

        $this->filesystem()->writeStream($name, $resource);

        fclose($resource);

        return $this->createFile($name);
    }

    public function deleteFile(string $path): bool
    {
        return $this->findFile($path)?->delete();
    }

    public function downloadUrl(string $path, int $livetime = 3600): string
    {
        return $this->findFile($path)?->downloadUrl($livetime);
    }

    /**
     * @param string $path
     * @return null|FileInterface
     */
    public function findFile(string $path): ?FileInterface
    {
        if ($this->fileMissing($path)) {
            return null;
        }
        return $this->createFile($path);
    }

    public function fileExists(string $path): bool
    {
        return $this->filesystem()->exists($path);
    }

    public function fileMissing(string $path): bool
    {
        return !$this->fileExists($path);
    }

    /**
     * @param string $path
     * @return FolderInterface|null
     */
    public function findFolder(string $path): ?FolderInterface
    {
        if ($this->fileMissing($path)) {
            return null;
        }

        return new Folder($path, $this->filesystem());
    }

    public function isDirectory(string $path): bool
    {
        if ($this->filesystem()->exists($path)) {
            return false;
        }

        if (method_exists($this->filesystem(), 'isDirectory')) {
            return $this->filesystem()->isDirectory($this->path);
        }

        return $this->filesystem()->type($this->path) === 'dir';
    }

    public function path(string $path): string
    {
        return $this->findFile($path)->path();
    }

    public function fullPath(string $path): string
    {
        return $this->findFile($path)->fullPath();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function filesystem(): Filesystem
    {
        if (isset($this->filesystem)) {
            return $this->filesystem;
        }

        return $this->filesystem = $this->filesystemFactory->disk($this->name);
    }

    public function createFile(string $path): FileInterface
    {
        return new File($path, $this);
    }
}
