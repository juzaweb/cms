<?php
/**
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
use Mymo\Theme\Facades\Theme;

class FrontendController extends Controller
{
    public function callAction($method, $parameters)
    {
        Theme::set('mymo');

        return parent::callAction($method, $parameters);
    }
}