<?php

namespace Juzaweb\CMS\Support\Updater;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Juzaweb\CMS\Abstracts\UpdateManager;
use Juzaweb\CMS\Facades\CacheGroup;
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

        $this->responseErrors($response);

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

    public function afterFinish(): void
    {
        CacheGroup::pull('theme_update_keys');

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

    protected function fetchData(): object
    {
        $uri = "themes/{$this->name}/update";

        $response = $this->api->get(
            $uri,
            $this->getDefaultApiParams()
        );

        $this->responseErrors($response);

        return $response;
    }

    protected function getDefaultApiParams(): array
    {
        $params = [
            'cms_version' => Version::getVersion(),
            'current_version' => $this->getCurrentVersion(),
            'domain' => request()->getHttpHost(),
        ];

        $activationCodes = get_config('theme_activation_codes', []);

        if (isset($activationCodes[Str::snake($this->name)])) {
            $params['use_token'] = $activationCodes[Str::snake($this->name)]['token'] ?? null;
        }

        return $params;
    }

    protected function getCacheKey(): string
    {
        return 'theme_' . $this->name;
    }

    protected function getLocalPath(): string
    {
        return config('juzaweb.theme.path').'/'.$this->name;
    }
}
