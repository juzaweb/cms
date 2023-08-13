<?php

namespace Juzaweb\CMS\Support\Updater;

use Illuminate\Support\Facades\Artisan;
use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\CMS\Abstracts\UpdateManager;
use Juzaweb\CMS\Console\Commands\ClearCacheCommand;
use Juzaweb\CMS\Version;

class CmsUpdater extends UpdateManager
{
    protected array $updatePaths = [
        'modules',
        'vendor',
        'bootstrap/cache/packages.php',
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

    public function afterUpdateFileAndFolder()
    {
        Artisan::call('package:discover', ['--ansi' => true]);
    }

    public function afterFinish()
    {
        Artisan::call(ClearCacheCommand::class);

        Artisan::call('migrate', ['--force' => true]);

        event(new DumpAutoloadPlugin());

        Artisan::call(
            'cms:publish',
            [
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
