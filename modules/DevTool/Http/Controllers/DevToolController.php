<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Controllers;

use Illuminate\Contracts\View\View;
use Inertia\Response;
use Juzaweb\CMS\Http\Controllers\BackendController;

class DevToolController extends BackendController
{
    protected string $template = 'inertia';

    public function index(): View|Response
    {
        return $this->view('dev-tool/index');
    }
}
