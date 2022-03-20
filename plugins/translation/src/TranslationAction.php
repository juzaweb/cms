<?php

namespace Juzaweb\Translation;

use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class TranslationAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'registerMenus']);
    }

    public function registerMenus()
    {
        HookAction::registerAdminPage(
            'translations',
            [
                'title' => trans('cms::app.translations'),
                'menu' => [
                    'icon' => 'fa fa-language',
                    'position' => 90,
                ]
            ]
        );
    }
}
