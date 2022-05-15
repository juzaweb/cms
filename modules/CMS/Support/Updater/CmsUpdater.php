<?php

namespace Juzaweb\CMS\Support\Updater;

use Illuminate\Support\Facades\Artisan;
use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\CMS\Abstracts\UpdateManager;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Version;

class CmsUpdater extends UpdateManager
{
    protected array $updatePaths = [
        'modules',
        'vendor',
        'composer.json',
        'composer.lock',
    ];

    public function getCurrentVersion(): string
    {
        return get_version_by_tag(Version::getVersion());
    }

    public function getVersionAvailable(): string
    {
        $uri = 'cms/version-available';
        $data = [
            'current_version' => $this->getCurrentVersion(),
        ];

        $response = $this->api->get($uri, $data);

        $this->responseErrors($response);

        return get_version_by_tag($response->data->version);
    }

    public function afterFinish()
    {
        Artisan::call('juzacms:cache-clear');

        Artisan::call('migrate', ['--force' => true]);

        event(new DumpAutoloadPlugin());

        Artisan::call(
            'vendor:publish',
            [
                '--tag' => 'cms_assets',
                '--force' => true,
            ]
        );

        /**
         * @var Plugin[] $plugins
         */
        $plugins = app('plugins')->all();
        foreach ($plugins as $plugin) {
            if (!$plugin->isEnabled()) {
                continue;
            }

            $plugin->disable();
            $plugin->enable();
        }

        $theme = jw_current_theme();
        Artisan::call(
            'theme:publish',
            [
                'theme' => $theme,
                'type' => 'assets',
            ]
        );
    }

    public function getUploadPaths(): array
    {
        if (JW_PLUGIN_AUTOLOAD) {
            return parent::getUploadPaths();
        }

        return [
            'modules',
        ];
    }

    protected function getCacheKey(): string
    {
        return 'cms_update';
    }

    protected function fetchData(): object
    {
        $uri = 'cms/update';

        $response = $this->api->get(
            $uri,
            [
                'current_version' => $this->getCurrentVersion(),
            ]
        );

        $this->responseErrors($response);

        return $response;
    }

    protected function getLocalPath(): string
    {
        return base_path();
    }
}
