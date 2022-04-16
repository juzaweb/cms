<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Facades\App;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Illuminate\Support\Collection;

class PageResourceController extends BackendController
{
    protected $page;
    
    public function callAction($method, $parameters)
    {
        $this->page = $this->findPageOrFail($parameters['slug']);
        
        $callback = $this->page->get('callback');
    
        do_action(Action::BACKEND_CALL_ACTION, $method, $parameters);
        
        return App::call([app($callback), $method]);
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
