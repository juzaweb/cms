<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Facades\HookAction;

class PageController extends BackendController
{
    protected $page;
    
    public function __invoke($slug)
    {
        $this->page = $this->findPageOrFail($slug);
        
        $callback = $this->page->get('callback');
        
        if (is_string($callback[0])) {
            return App::call([app($callback[0]), $callback[1]]);
        }
        
        return App::call($callback);
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
