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

trait ThemeHookAction
{
    public function registerFrontendAjax(string $key, array $args = []): void
    {
        $defaults = [
            'auth' => false,
            'key' => $key,
        ];

        /*preg_match_all("/\{([a-z0-9\_]+)\}/", $key, $matches);

        if (!empty($matches[1])) {
            $defaults['params'] = $matches[1];
            $defaults['key'] = preg_replace("/\.\{([a-z0-9\_]+)\}/", '', $defaults['key']);
        }*/

        $args = array_merge($defaults, $args);

        if (empty($args['callback'])) {
            throw new Exception('Frontend Ajax callback option is required.');
        }

        $this->globalData->set('frontend_ajaxs.' . $key, new Collection($args));
    }

    public function registerThemeTemplate(string $key, array $args = []): void
    {
        $defaults = [
            'key' => $key,
            'name' => '',
            'view' => '',
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('templates.' . $key, new Collection($args));
    }

    public function registerThemeSetting(string $name, string $label, array $args = []): void
    {
        $args = [
            'name' => $name,
            'label' => $label,
            'data' => $args,
        ];

        $this->globalData->set("theme_settings.{$name}", new Collection($args));
    }

    public function registerProfilePage(string $key, array $args = []): void
    {
        $slug = str_replace(['_'], ['-'], $key);

        $default = [
            'title' => '',
            'key' => $key,
            'slug' => $slug,
            'url' => route(
                'profile',
                $key == 'index' ? null : '/' . $slug
            ),
        ];

        $args = array_merge($default, $args);

        $this->globalData->set('profile_pages.' . $key, new Collection($args));
    }
}
