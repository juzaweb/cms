<?php

namespace Juzaweb\Http\Controllers\Backend;

use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Models\Page;
use Juzaweb\Traits\PostTypeController;

class PageController extends BackendController
{
    use PostTypeController {
        getDataForForm as DataForForm;
    }

    protected $viewPrefix = 'juzaweb::backend.page';

    /**
     * @return string
     */
    protected function getModel()
    {
        return Page::class;
    }

    protected function getDataForForm($model)
    {
        $data = $this->DataForForm($model);
        $templates = HookAction::getThemeTemplates();
        $data['templates'] = [];

        foreach ($templates as $key => $template) {
            $data['templates'][$key] = $template['name'];
        }

        return $data;
    }
}
