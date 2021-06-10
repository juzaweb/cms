<?php

namespace Mymo\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
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

    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    protected function view(string $view)
    {
        $this->setupLayout();
        $this->layout->content = View::make($view);
        return $this->layout;
    }
}
