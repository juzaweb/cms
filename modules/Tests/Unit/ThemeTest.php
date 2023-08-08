<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Unit;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Juzaweb\CMS\Support\Theme;
use Juzaweb\Tests\TestCase;

class ThemeTest extends TestCase
{
    public function testEnable()
    {
        /**
         * @var Theme $theme
         */
        $theme = app('themes')->find('default');

        $theme->activate();

        $this->assertTrue($theme->isActive());

        $this->assertDatabaseHas(
            'configs',
            ['code' => 'theme_statuses']
        );

        $this->assertTrue(jw_current_theme() == 'default');
    }

    public function testDelete()
    {
        $themeName = 'gamxo';

        $theme = app('themes')->find($themeName);

        $themePath = config('juzaweb.theme.path') . "/{$themeName}";

        $destination = Storage::disk('local')->path("backups/{$themeName}");

        File::copyDirectory($themePath, $destination);

        $theme->delete();

        $this->assertDirectoryDoesNotExist(
            $themePath
        );

        File::copyDirectory($destination, $themePath);

        $this->assertDirectoryExists(
            $themePath
        );
    }
}
