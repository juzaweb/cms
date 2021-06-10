<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/10/2021
 * Time: 3:31 PM
 */

namespace Mymo\Theme\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RouteController extends FrontendController
{
    public function index(Request $request, $base, $slug)
    {
        $permalinks = $this->getPermalinks();
        $permalink = $permalinks->where('base', $base);
        if ($permalink) {
            if ($callback = $permalink->last()->get('callback')) {
                if ($slug) {
                    if ($slug[0] == '/') {
                        $slug = str_replace($slug[0], '', $slug);
                    }

                    return $this->callController($callback, 'content', [
                        'slug' => $slug
                    ]);
                }

                return $this->callController($callback, 'index');
            }
        }

        die('404');
    }

    protected function getPermalinks()
    {
        return collect(apply_filters('mymo.permalinks', []));
    }

    protected function callController($callback, $method, $parameters = [])
    {
        return App::call($callback . '@' . $method, $parameters);
    }
}