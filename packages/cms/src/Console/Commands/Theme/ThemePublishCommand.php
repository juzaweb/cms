<?php

namespace Juzaweb\Console\Commands\Theme;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Juzaweb\Facades\Theme;

class ThemePublishCommand extends Command
{
    protected $signature = 'theme:publish {theme?} {type?}';

    public function handle()
    {
        $theme = (string) $this->argument('theme');
        $type = (string) $this->argument('type');

        if (empty($theme)) {
            $theme = jw_current_theme();
        }

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

    protected function publishViews(string $theme)
    {
        $sourceFolder = Theme::getThemePath($theme) . '/views';
        $publicFolder = resource_path('views/vendor/theme_' . $theme);

        if (! File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }

    protected function publishLang(string $theme)
    {
        $sourceFolder = Theme::getThemePath($theme) . '/lang';
        $publicFolder = resource_path('lang/vendor/theme_' . $theme);

        if (! File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }

    protected function publishAssets(string $theme)
    {
        $sourceFolder = Theme::getThemePath($theme) . '/assets';
        $publicFolder = Theme::publicPath($theme) . '/assets';

        if (! File::isDirectory($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true, true);
        }

        File::copyDirectory($sourceFolder, $publicFolder);
    }
}
