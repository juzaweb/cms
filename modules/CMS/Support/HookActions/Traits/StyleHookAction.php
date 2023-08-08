<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\HookActions\Traits;

use Illuminate\Support\Collection;

trait StyleHookAction
{
    public function enqueueScript(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void
    {
        if (!is_url($src)) {
            $src = asset($src);
        }

        $this->globalData->set(
            "scripts.{$key}",
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                ]
            )
        );
    }

    public function enqueueStyle(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void
    {
        if (!is_url($src)) {
            $src = asset($src);
        }

        $this->globalData->set(
            "styles.{$key}",
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                ]
            )
        );
    }

    public function enqueueFrontendScript(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false,
        array $options = []
    ): void {
        if (!is_url($src)) {
            $src = theme_assets($src);
        }

        $this->globalData->set(
            "frontend_scripts.{$key}",
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                    'options' => $options,
                ]
            )
        );
    }

    public function enqueueFrontendStyle(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false
    ): void {
        if (!is_url($src)) {
            $src = theme_assets($src);
        }

        $this->globalData->set(
            "frontend_styles.{$key}",
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                ]
            )
        );
    }
}
