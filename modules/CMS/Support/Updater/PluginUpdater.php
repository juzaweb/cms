<?php

namespace Juzaweb\CMS\Support\Updater;

use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\CMS\Abstracts\UpdateManager;
use Juzaweb\CMS\Facades\CacheGroup;
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

        $this->responseErrors($response);

        return get_version_by_tag($response->data->version);
    }

    public function getCurrentVersion(): string
    {
        $module = app('plugins')->find($this->name);
        if (empty($module)) {
            return "0";
        }

        return $module->getVersion();
    }

    public function afterFinish(): void
    {
        CacheGroup::pull('plugin_update_keys');

        event(new DumpAutoloadPlugin());

        /**
         * @var Plugin $plugin
         */
        $plugin = app('plugins')->find($this->name);
        if ($plugin->isEnabled()) {
            $plugin->disable();
            $plugin->enable();
        }
    }

    protected function fetchData(): object
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

        $this->responseErrors($response);

        return $response;
    }

    protected function getCacheKey(): string
    {
        return 'plugin_' . str_replace('/', '_', $this->name);
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

        $folder = explode('/', $this->name);

        return config('juzaweb.plugin.path').'/'.$folder[1];
    }
}
