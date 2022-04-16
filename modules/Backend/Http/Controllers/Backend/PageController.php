<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Facades\HookAction;

class PageController extends BackendController
{
    protected $page;
    
    public function callAction($method, $parameters)
    {
        $this->page = $this->findPageOrFail($parameters['slug']);
        
        $callback = $this->page->get('callback');
    
        do_action(Action::BACKEND_CALL_ACTION, $method, $parameters);
        
        if (is_array($callback) && is_string($callback[0])) {
            return App::call([app($callback[0]), $callback[1]]);
        }
    
        return App::call([app($callback), $method], $parameters);
    }
    
    protected function findPageOrFail(string $slug) : Collection
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
