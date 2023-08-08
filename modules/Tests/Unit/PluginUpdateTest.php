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
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Support\Updater\PluginUpdater;
use Juzaweb\Tests\TestCase;

class PluginUpdateTest extends TestCase
{
    public function testInstall()
    {
        $updater = app(PluginUpdater::class)->find('juzaweb/movie');

        $updater->update();

        $this->assertDirectoryExists(
            config('juzaweb.plugin.path') . "/movie"
        );

        $plugin = Plugin::find('juzaweb/movie');

        $this->assertNotEmpty($plugin);
    }

    public function testUpdate()
    {
        $plugin = Plugin::find('juzaweb/movie');

        $composer = File::get($plugin->getPath() . "/composer.json");

        $composer = str_replace($plugin->getVersion(), '1.0', $composer);

        File::put($plugin->getPath() . "/composer.json", $composer);

        $plugin = Plugin::find('juzaweb/movie');
        $this->assertEquals($plugin->getVersion(), '1.0');

        $updater = app(PluginUpdater::class)->find('juzaweb/movie');

        $updater->update();

        $plugin = Plugin::find('juzaweb/movie');
        $this->assertNotEquals($plugin->getVersion(), '1.0');
    }
}
