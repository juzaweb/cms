<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Unit;

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
        $theme = app('themes')->find('gamxo');

        $theme->delete();

        $this->assertDirectoryDoesNotExist(
            config('juzaweb.theme.path') . "/gamxo"
        );
    }
}
