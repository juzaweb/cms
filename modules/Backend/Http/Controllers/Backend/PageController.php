<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Facades\HookAction;

class PageController extends BackendController
{
    protected $page;
    
    public function callAction($method, $parameters)
    {
        $this->page = $this->findPageOrFail();
    
        return parent::callAction($method, $parameters);
    }
    
    /**
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findPageOrFail() : Collection
    {
        $page = HookAction::getAdminPages($this->getPageSlug());
        if (empty($page)) {
            abort(404);
        }
        
        if (is_array($page)) {
            abort(404);
        }
        
        return $page;
    }
    
    protected function getPageSlug()
    {
        $slugs = explode('/', Route::getCurrentRoute()->uri);
        unset($slugs[0]);
        return implode('.', $slugs);
    }
}
