<?php

namespace Mymo\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Mymo\Theme\Facades\Theme;

class FrontendController extends Controller
{
    /**
     * Set a layout properties here, so you can globally
     * call it in all of your Controllers
     */
    protected $layout = 'theme::layout';

    public function callAction($method, $parameters)
    {
        /**
         * Action after call action frontend
         * Add action to this hook add_action('frontend.call_action', $callback)
         * */
        do_action('frontend.call_action', $method, $parameters);

        Theme::set($this->getCurrentTheme());

        return parent::callAction($method, $parameters);
    }

    protected function getCurrentTheme()
    {
        return get_config('activated_theme', 'default');
    }
}
