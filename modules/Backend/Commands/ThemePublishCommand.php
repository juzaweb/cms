<?php

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Facades\ThemeLoader;

class ThemePublishCommand extends Command
{
    protected $signature = 'theme:publish {theme?} {type?}';

    public function handle()
    {
        $theme = $this->argument('theme') ?? jw_current_theme();

        $type = (string) $this->argument('type');

        if (empty($type)) {
            $this->publishAssets($theme);
        } else {
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
        }

        $this->info('Publish Theme Successfully');
    }

    protected function publishAssets(string $theme)
    {
        $sourceFolder = ThemeLoader::getThemePath($theme) . '/assets/public';
        $publicFolder = ThemeLoader::publicPath($theme) . '/assets';

        if (! File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }

    protected function publishViews(string $theme)
    {
        $sourceFolder = ThemeLoader::getThemePath($theme) . '/views';
        $publicFolder = resource_path('views/themes/' . $theme);

        if (! File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }

    protected function publishLang(string $theme)
    {
        $sourceFolder = ThemeLoader::getThemePath($theme) . '/lang';
        $publicFolder = resource_path('lang/themes/' . $theme);

        if (! File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }
}
