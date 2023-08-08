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

use Juzaweb\CMS\Support\Plugin;
use Juzaweb\Tests\TestCase;

class PluginTest extends TestCase
{
    public function testEnable()
    {
        $plugins = app('plugins')->all();
        foreach ($plugins as $plugin) {
            /**
             * @var Plugin $plugin
             */

            $this->printText("Enable {$plugin->getName()}");

            $plugin->enable();

            $this->assertTrue($plugin->isEnabled());
        }

        $this->assertDatabaseHas(
            'configs',
            ['code' => 'plugin_statuses']
        );

        $this->printText("Check Enable DB");
        $dbPlugins = get_config('plugin_statuses', []);
        $dbPlugins = array_keys($dbPlugins);
        $notEnable = collect(array_keys($plugins))
            ->filter(fn ($item) => !in_array($item, $dbPlugins))
            ->all();

        $this->assertEmpty($notEnable);
    }

    public function testDisable()
    {
        $plugins = app('plugins')->all();

        foreach ($plugins as $plugin) {
            /**
             * @var Plugin $plugin
             */

            $this->printText("Disable {$plugin->getName()}");

            $plugin->disable();

            $this->assertTrue($plugin->isDisabled());
        }

        $this->printText("Check Enable DB");
        $dbPlugins = get_config('plugin_statuses', []);
        $dbPlugins = array_keys($dbPlugins);
        $this->assertEmpty($dbPlugins);
    }
}
