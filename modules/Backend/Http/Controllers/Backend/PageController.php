<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Juzaweb\CMS\Http\Controllers\BackendController;
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
    
    protected $page;
    
    public function router($slug)
    {
        $this->page = $this->findPageOrFail2($slug);
        
        $callback = $this->page->get('callback');
        
        if (is_string($callback[0])) {
            return App::call([app($callback[0]), $callback[1]]);
        }
        
        return App::call($callback);
    }
    
    protected function findPageOrFail2(string $slug) : Collection
    {
        $key = str_replace('/', '.', $slug);
        $page = HookAction::getAdminPages($key);
        if (empty($page)) {
            abort(404);
        }
        
        if (is_array($page)) {
            abort(404);
        }
        
        return $page;
    }
}
