<?php

namespace Juzaweb\CMS\Support\Process;

use Juzaweb\CMS\Support\Plugin;

class Updater extends Runner
{
    /**
     * Update the dependencies for the specified plugin by given the plugin name.
     *
     * @param string $module
     */
    public function update($module)
    {
        $module = $this->module->findOrFail($module);

        chdir(base_path());

        $this->installRequires($module);
        $this->installDevRequires($module);
        $this->copyScriptsToMainComposerJson($module);
    }

    /**
     * @param Plugin $module
     */
    private function installRequires(Plugin $module)
    {
        $packages = $module->getComposerAttr('require', []);

        $concatenatedPackages = '';
        foreach ($packages as $name => $version) {
            $concatenatedPackages .= "\"{$name}:{$version}\" ";
        }

        if (! empty($concatenatedPackages)) {
            $this->run("composer require {$concatenatedPackages}");
        }
    }

    /**
     * @param Plugin $module
     */
    private function installDevRequires(Plugin $module)
    {
        $devPackages = $module->getComposerAttr('require-dev', []);

        $concatenatedPackages = '';
        foreach ($devPackages as $name => $version) {
            $concatenatedPackages .= "\"{$name}:{$version}\" ";
        }

        if (! empty($concatenatedPackages)) {
            $this->run("composer require --dev {$concatenatedPackages}");
        }
    }

    /**
     * @param Plugin $module
     */
    private function copyScriptsToMainComposerJson(Plugin $module)
    {
        $scripts = $module->getComposerAttr('scripts', []);

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        foreach ($scripts as $key => $script) {
            if (array_key_exists($key, $composer['scripts'])) {
                $composer['scripts'][$key] = array_unique(array_merge($composer['scripts'][$key], $script));

                continue;
            }
            $composer['scripts'] = array_merge($composer['scripts'], [$key => $script]);
        }

        file_put_contents(base_path('composer.json'), json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}
