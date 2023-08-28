<?php

namespace Juzaweb\CMS\Support\Media;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\File as FileFacade;
use Juzaweb\CMS\Contracts\Media\Disk as DiskContract;
use Juzaweb\CMS\Interfaces\Media\FileInterface;
use Juzaweb\CMS\Interfaces\Media\FolderInterface;
use League\MimeTypeDetection\FinfoMimeTypeDetector;

class Disk implements DiskContract
{
    protected string $name;
    protected Factory $filesystemFactory;
    protected Filesystem $filesystem;

    public function __construct(string $name, Factory $filesystemFactory)
    {
        $this->name = $name;
        $this->filesystemFactory = $filesystemFactory;
    }

    public function upload(string $path, string $name, array $options = []): FileInterface
    {
        if (!isset($options['mimetype'])) {
            $options['mimetype'] = FileFacade::mimeType($path);
        }

        $this->filesystem()->put($name, fopen($path, 'r+'), $options);

        return $this->createFile($name);
    }

    public function put(string $path, string $contents, array $options = []): FileInterface
    {
        if (!isset($options['mimetype'])) {
            $detector = new FinfoMimeTypeDetector();
            $options['mimetype'] = $detector->detectMimeTypeFromBuffer($contents);
        }

        $this->filesystem()->put($path, $contents, $options);

        return $this->createFile($path);
    }

    public function deleteFile(string $path): bool
    {
        return $this->findFile($path)?->delete();
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

    public function findFileOrFail(string $path): FileInterface
    {
        if ($file = $this->findFile($path)) {
            return $file;
        }

        throw new FileNotFoundException($path);
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

    public function findFolderOrFail(string $path): FolderInterface
    {
        if ($folder = $this->findFolder($path)) {
            return $folder;
        }

        throw new FileNotFoundException($path);
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
        return $this->findFileOrFail($path)->path();
    }

    public function fullPath(string $path): string
    {
        return $this->findFileOrFail($path)->fullPath();
    }

    public function get(string $path): string
    {
        return $this->findFileOrFail($path)->get();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function filesystem(): Filesystem
    {
        return $this->filesystem ?? ($this->filesystem = $this->filesystemFactory->disk($this->name));
    }

    public function createFile(string $path): FileInterface
    {
        return new File($path, $this);
    }

    public function setFileSystem(Filesystem $filesystem): static
    {
        $this->filesystem = $filesystem;

        return $this;
    }
}
