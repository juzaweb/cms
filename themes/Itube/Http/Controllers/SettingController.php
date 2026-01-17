<?php

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\Controllers;

use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Facades\ThemeSetting;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Themes\Itube\Http\Requests\SettingRequest;

class SettingController extends AdminController
{
    public function index()
    {
        Breadcrumb::add(__('itube::translation.settings'));

        $socials = config('itube.socials', []);

        return view(
            'itube::setting.index',
            compact('socials')
        );
    }

    public function update(SettingRequest $request)
    {
        ThemeSetting::sets($request->safe()->except(['_token']));

        return $this->success(
            [
                'message' => __('itube::translation.settings_updated_successfully'),
                'redirect' => action([self::class, 'index']),
            ]
        );
    }
}
