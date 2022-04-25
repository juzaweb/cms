<?php

namespace Juzaweb\CMS\Support\Updater;

use Juzaweb\CMS\Support\Manager\UpdateManager;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Version;

class PluginUpdater extends UpdateManager
{
    protected string $name;

    public function find($name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getVersionAvailable(): string
    {
        $uri = "plugins/{$this->name}/version-available";
        $data = [
            'cms_version' => Version::getVersion(),
            'current_version' => $this->getCurrentVersion(),
        ];

        $response = $this->api->get($uri, $data);

        return get_version_by_tag($response->version);
    }

    public function getCurrentVersion(): string
    {
        $module = app('plugins')->find($this->name);
        if (empty($module)) {
            return "0";
        }

        return $module->getVersion();
    }

    public function fetchData(): void
    {
        $uri = "plugins/{$this->name}/update";

        $response = $this->api->get(
            $uri,
            [
                'current_version' => $this->getCurrentVersion(),
                'cms_version' => Version::getVersion(),
                'plugin' => $this->name,
            ]
        );

        $this->response = $response;
    }

    public function afterFinish(): void
    {
        /**
         * @var Plugin $plugin
         */
        $plugin = app('plugins')->find($this->name);
        if ($plugin->isEnabled()) {
            $plugin->disable();
            $plugin->enable();
        }
    }

    protected function getLocalPath(): string
    {
        /**
         * @var Plugin|null $plugin
         */
        $plugin = app('plugins')->find($this->name);

        if ($plugin) {
            return $plugin->getPath();
        }

        return config('juzaweb.plugin.path').'/'.$this->name;
    }
}
