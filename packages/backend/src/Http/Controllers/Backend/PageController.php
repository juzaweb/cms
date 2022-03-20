<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Facades\Route;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Backend\Facades\HookAction;

class PageController extends BackendController
{
    public function callAction($method, $parameters)
    {
        $callAction = parent::callAction($method, $parameters);

        $this->findPageOrFail();

        return $callAction;
    }

    protected function getPageSlug()
    {
        $slug = explode('/', Route::getCurrentRoute()->uri)[1];

        return $slug;
    }

    protected function findPageOrFail()
    {
        $page = HookAction::getAdminPages($this->getPageSlug());

        if (empty($page)) {
            abort(404);
        }

        return $page;
    }
}
