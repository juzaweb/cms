<?php

namespace Juzaweb\CMS\Support\Updater;

use Illuminate\Support\Facades\Artisan;
use Juzaweb\CMS\Support\Manager\UpdateManager;
use Juzaweb\CMS\Version;

class ThemeUpdater extends UpdateManager
{
    protected string $name;

    public function getVersionAvailable(): string
    {
        $uri = "themes/{$this->name}/version-available";
        $data = [
            'cms_version' => Version::getVersion(),
            'current_version' => $this->getCurrentVersion(),
        ];

        $response = $this->api->get($uri, $data);

        return get_version_by_tag($response->data->version);
    }

    public function getCurrentVersion(): string
    {
        $module = app('themes')->find($this->name);
        if (empty($module)) {
            return "0";
        }

        return $module->getVersion();
    }

    public function find($name): static
    {
        $this->name = $name;

        return $this;
    }

    public function fetchData(): void
    {
        $uri = "themes/{$this->name}/update";

        $response = $this->api->get(
            $uri,
            [
                'current_version' => $this->getCurrentVersion(),
                'cms_version' => Version::getVersion()
            ]
        );

        $this->response = $response;
    }

    public function afterFinish(): void
    {
        if ($this->name == jw_current_theme()) {
            Artisan::call(
                'theme:publish',
                [
                    'theme' => $this->name,
                    'type' => 'assets',
                ]
            );
        }
    }

    protected function getLocalPath(): string
    {
        return config('juzaweb.theme.path').'/'.$this->name;
    }
}
