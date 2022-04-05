<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/10/2021
 * Time: 3:31 PM
 */

namespace Juzaweb\Backend\Http\Controllers\Frontend;

use Illuminate\Support\Facades\App;
use Juzaweb\Http\Controllers\FrontendController;

class RouteController extends FrontendController
{
    public function index($slug = null)
    {
        $slug = explode('/', $slug);
        $base = apply_filters('theme.permalink.base', $slug[0], $slug);
        $permalink = $this->getPermalinks($base);

        if ($permalink && $callback = $permalink->get('callback')) {
            return $this->callController($callback, 'index', $slug);
        }

        return $this->callController(
            PageController::class,
            'index',
            $slug
        );
    }

    protected function callController($callback, $method = 'index', $parameters = [])
    {
        do_action('theme.call_controller', $callback, $method, $parameters);

        $parameters = array_values($parameters);

        return App::call($callback . '@' . $method, $parameters);
    }
}
