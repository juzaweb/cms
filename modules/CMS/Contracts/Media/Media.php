<?php

namespace Juzaweb\CMS\Contracts\Media;

use Juzaweb\CMS\Interfaces\Media\FileInterface;
use Juzaweb\CMS\Support\Media\Disk;

/**
 * @see \Juzaweb\CMS\Support\Media\Media
 */
interface Media
{
    public function public(): Disk;

    public function protected(): Disk;

    public function tmp(): Disk;

    /**
     * @param string $token
     * @return bool|FileInterface
     */
    public function verifyDownloadToken(string $token);
}
