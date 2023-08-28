<?php

namespace Juzaweb\CMS\Support\Media;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Juzaweb\CMS\Contracts\Media\Media as MediaContract;

class Media implements MediaContract
{
    protected Application $app;
    protected Factory $filesystem;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->filesystem = $app['filesystem'];
    }

    public function public(): Disk
    {
        return $this->disk('public');
    }

    public function protected(): Disk
    {
        return $this->disk('protected');
    }

    public function tmp(): Disk
    {
        return $this->disk('tmp');
    }

    public function createFromFilesystem(string $name, Filesystem $filesystem): Disk
    {
        return (new Disk($name, $this->filesystem))->setFileSystem($filesystem);
    }

    public function disk(string $name): Disk
    {
        return new Disk($name, $this->filesystem);
    }

    public function getFactory(): Factory
    {
        return $this->filesystem;
    }
}
