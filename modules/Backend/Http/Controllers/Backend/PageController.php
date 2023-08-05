<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends BackendController
{
    protected Collection $page;

    public function callAction($method, $parameters): Response|View
    {
        $this->page = $this->findPageOrFail();

        return parent::callAction($method, $parameters);
    }

    protected function findPageOrFail(): Collection
    {
        $page = HookAction::getAdminPages($this->getPageSlug());

        if ($page === null) {
            abort(404);
        }

        if (is_array($page)) {
            $page = $this->recursiveGetPage($page);
        }

        return $page;
    }

    protected function recursiveGetPage($page)
    {
        $page = $page[$this->getPageSlug(2)];
        if (empty($page)) {
            abort(404);
        }

        if (is_array($page)) {
            $page = $this->recursiveGetPage($page);
        }

        return $page;
    }

    protected function getPageSlug($index = 1): string
    {
        $slugs = explode('/', Route::getCurrentRoute()->uri);

        return $slugs[$index];
    }
}
