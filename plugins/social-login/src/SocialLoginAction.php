<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\SocialLogin;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class SocialLoginAction extends Action
{
    public function handle()
    {
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'addSettingForm']
        );
    }

    public function addSettingForm()
    {
        HookAction::registerConfig([
            'socialites'
        ]);

        $socials = [
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'github',
        ];

        $data = get_config('socialites', []);

        HookAction::addSettingForm('social-login', [
            'name' => trans('juso::content.social_login'),
            'view' => view('juso::setting', compact('socials', 'data')),
            'priority' => 20
        ]);
    }
}
