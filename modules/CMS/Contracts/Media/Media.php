<?php

namespace Juzaweb\CMS\Contracts\Media;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Juzaweb\CMS\Support\Media\Disk;

/**
 * @see \Juzaweb\CMS\Support\Media\Media
 */
interface Media
{
    public function public(): Disk;

    public function protected(): Disk;

    public function tmp(): Disk;

    public function disk(string $name): Disk;

    public function createFromFilesystem(string $name, Filesystem $filesystem): Disk;

    public function getFactory(): Factory;
}
