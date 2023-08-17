<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Controllers;

use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Interfaces\Theme\ThemeInterface;
use Juzaweb\CMS\Interfaces\Theme\PluginInterface as Plugin;

class Controller extends BackendController
{
    protected string $template = 'inertia';

    protected function getThemeRegister(ThemeInterface $theme): array
    {
        return $theme->getRegister();
    }

    protected function getPluginRegister(Plugin $plugin): array
    {
        $register = '[]';

        if (File::exists($plugin->getPath('register.json'))) {
            $register = File::get($plugin->getPath('register.json'));
        }

        return json_decode($register, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function getConfigs(string $module): array
    {
        $configs = config("dev-tool.{$module}", []);

        $convertToArray = function (array $item, string $key) {
            $item['key'] = $key;
            return $item;
        };

        $configs['options'] = collect($configs['options'])
            ->map($convertToArray)
            ->values();

        return $configs;
    }

    protected function writeRegisterFile(Plugin|ThemeInterface $module, array $register): bool
    {
        return File::put(
            $module->getPath('register.json'),
            json_encode($register, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT)
        );
    }
}
