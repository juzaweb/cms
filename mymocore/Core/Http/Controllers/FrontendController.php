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
 * Date: 5/24/2021
 * Time: 8:36 PM
 */

namespace Mymo\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Mymo\Theme\Facades\Theme;

class FrontendController extends Controller
{
    /**
     * Set a layout properties here, so you can globally call it in all of your Controllers
     */
    protected $layout = 'frontend::layout';

    public function callAction($method, $parameters)
    {
        /**
         * TAD CMS: Action after call action frontend
         * Add action to this hook add_action('frontend.call_action', $callback)
         * */
        do_action('frontend.call_action', $method, $parameters);

        Theme::set($this->getCurrentTheme());

        return parent::callAction($method, $parameters);
    }

    protected function getCurrentTheme()
    {
        return get_config('activated_theme', 'mymo');
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