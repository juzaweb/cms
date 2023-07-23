<?php

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Facades\ThemeLoader;
use Symfony\Component\Console\Input\InputArgument;

class ThemePublishCommand extends Command
{
    protected $signature = 'theme:publish {theme?} {type?}';

    public function handle(): void
    {
        $theme = $this->argument('theme') ?? jw_current_theme();

        $type = $this->argument('type') ?? 'assets';

        switch ($type) {
            case 'views':
                $this->publishViews($theme);
                break;
            case 'lang':
                $this->publishLang($theme);
                break;
            case 'assets':
                $this->publishAssets($theme);
                break;
        }

        $this->info('Publish Theme Successfully');
    }

    protected function publishAssets(string $theme): void
    {
        $sourceFolder = ThemeLoader::getThemePath($theme).'/assets/public';
        $publicFolder = ThemeLoader::publicPath($theme).'/assets';

        if (!File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);

        $buildFolder = ThemeLoader::getThemePath($theme).'/assets/build';
        $publicBuildFolder = ThemeLoader::publicPath($theme).'/build';

        File::deleteDirectory($publicBuildFolder, true);
        File::makeDirectory($publicBuildFolder, 0755, true, true);

        File::copyDirectory($buildFolder, $publicBuildFolder);
    }

    protected function publishViews(string $theme): void
    {
        $sourceFolder = ThemeLoader::getThemePath($theme).'/views';
        $publicFolder = resource_path('views/themes/'.$theme);

        if (!File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }

    protected function publishLang(string $theme): void
    {
        $sourceFolder = ThemeLoader::getThemePath($theme).'/lang';
        $publicFolder = resource_path('lang/themes/'.$theme);

        if (!File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }

    protected function getArguments(): array
    {
        return [
            ['theme', InputArgument::OPTIONAL, 'Theme publish assets.', null],
            ['type', InputArgument::OPTIONAL, 'Type: assets, views, lang'],
        ];
    }
}
