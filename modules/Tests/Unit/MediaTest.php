<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\FileManager;
use Juzaweb\Tests\TestCase;

class MediaTest extends TestCase
{
    public function testUploadByPath()
    {
        Storage::put('app/tmps/test.txt', date('Y-m-d H:i:s'));

        $media = FileManager::addFile(Storage::path('app/tmps/test.txt'), 'file', null, User::first()->id);

        $this->assertNotEmpty($media->path);

        $this->assertFileDoesNotExist(Storage::path('app/tmps/test.txt'));
    }

    public function testUploadByUrl()
    {
        $img = 'https://cdn.juzaweb.com/jw-styles/juzaweb/images/thumb-default.png';

        $media = FileManager::addFile($img, 'image', null, User::first()->id);

        $this->assertNotEmpty($media->path);
    }
}
