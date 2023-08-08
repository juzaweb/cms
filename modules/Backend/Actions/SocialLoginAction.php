<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

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
        $socials = [
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'github',
        ];

        $data = get_config('socialites', []);

        HookAction::addSettingForm(
            'social-login',
            [
                'name' => trans('cms::app.social_login'),
                'view' => view(
                    'cms::backend.setting.system.form.social_login',
                    compact('socials', 'data')
                ),
                'priority' => 40
            ]
        );
    }
}
