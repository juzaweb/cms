<?php

namespace Juzaweb\Tool;

use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Tool\Http\Controllers\ImportController;

class ToolAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'addAdminMenu']);
    }

    public function addAdminMenu()
    {
        HookAction::registerAdminPage('imports', [
            'title' => trans('juto::tool.import'),
            'view' => 'juto::import',
        ]);

        HookAction::registerAdminAjax('imports', [
            'method' => 'post',
            'callback' => [ImportController::class, 'import']
        ]);

        /*HookAction::addAdminMenu(
            trans('juto::tool.tools'),
            'tools',
            [
                'icon' => 'fa fa-cogs',
                'position' => 91,
            ]
        );

        HookAction::addAdminMenu(
            trans('juto::tool.import'),
            'page.imports',
            [
                'icon' => 'fa fa-cogs',
                'position' => 1,
                'parent' => 'tools',
            ]
        );*/
    }
}
