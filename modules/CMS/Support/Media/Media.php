<?php

namespace Juzaweb\CMS\Support\Media;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Crypt;
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

    public function verifyDownloadToken(string $token)
    {
        $data = json_decode(Crypt::decryptString(urldecode($token)), true);

        try {
            if (sha1($data['path']) !== $data['hash']) {
                return false;
            }

            if ($data['time'] + $data['livetime'] < time()) {
                return false;
            }
        } catch (\Throwable $e) {
            return false;
        }

        return $this->disk($data['disk'])->createFile($data['path']);
    }

    public function disk(string $name): Disk
    {
        return new Disk($name, $this->filesystem);
    }
}
