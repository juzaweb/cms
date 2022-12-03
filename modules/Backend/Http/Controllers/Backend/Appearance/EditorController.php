<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Appearance;

use Juzaweb\CMS\Http\Controllers\BackendController;

class EditorController extends BackendController
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $title = trans('cms::app.theme_editor');

        return view('cms::backend.appearance.editor.index', compact('title'));
    }
}
